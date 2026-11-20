<?php

namespace App\Console\Commands;

use App\Models\GroupBuySession;
use Illuminate\Console\Command;

class CheckGroupBuyStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'group-buy:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display summary metrics for all active and completed group-buy sessions';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $active = GroupBuySession::where('status', 'active')->where('expires_at', '>', now())->count();
        $completed = GroupBuySession::where('status', 'completed')->count();
        $expired = GroupBuySession::where('status', 'expired')->count();
        $total = GroupBuySession::count();

        $this->info("=== Cartiva Group Buy Metrics ===");
        $this->line("Active Pools:    {$active}");
        $this->line("Completed Deals: {$completed}");
        $this->line("Expired Deals:   {$expired}");
        $this->line("Total Created:   {$total}");

        return Command::SUCCESS;
    }
}
