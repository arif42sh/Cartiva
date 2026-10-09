<?php

namespace App\Console\Commands;

use App\Models\GroupBuySession;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckGroupBuyExpirations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cartiva:check-group-expirations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks active group buying sessions, completes formed groups, and expires/refunds timed-out groups';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Group Buy expiration check...');

        $completedCount = 0;
        $expiredCount = 0;

        DB::transaction(function () use (&$completedCount, &$expiredCount) {
            // 1. Groups that met required members
            $readyGroups = GroupBuySession::where('status', 'active')
                ->whereColumn('current_members', '>=', 'required_members')
                ->get();

            foreach ($readyGroups as $session) {
                $session->update(['status' => 'completed']);
                $session->orders()
                    ->where('order_status', 'pending_group')
                    ->update(['order_status' => 'processing']);
                $completedCount++;
            }

            // 2. Active groups that exceeded their expiration time
            $expiredSessions = GroupBuySession::where('status', 'active')
                ->where('expires_at', '<=', now())
                ->get();

            foreach ($expiredSessions as $session) {
                if ($session->current_members >= $session->required_members) {
                    $session->update(['status' => 'completed']);
                    $session->orders()
                        ->where('order_status', 'pending_group')
                        ->update(['order_status' => 'processing']);
                    $completedCount++;
                } else {
                    $session->update(['status' => 'expired']);
                    $session->orders()
                        ->update([
                            'order_status' => 'refunded',
                            'payment_status' => 'refunded',
                        ]);
                    $expiredCount++;
                }
            }
        });

        $this->info("Completed: {$completedCount} group(s). Expired & Refunded: {$expiredCount} group(s).");
        return Command::SUCCESS;
    }
}
