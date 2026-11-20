<?php

namespace App\Listeners;

use App\Events\GroupBuyCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendGroupBuyNotifications implements ShouldQueue
{
    /**
     * Handle the event when a group buy session completes.
     */
    public function handle(GroupBuyCompleted $event): void
    {
        $session = $event->session;

        Log::info("Group Buy Pool #{$session->group_code} completed successfully with {$session->current_members} members. Orders transition to processing.");
    }
}
