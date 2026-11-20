<?php

namespace App\Events;

use App\Models\GroupBuySession;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupBuyCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public GroupBuySession $session;

    public function __construct(GroupBuySession $session)
    {
        $this->session = $session;
    }
}
