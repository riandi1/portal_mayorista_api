<?php

namespace App\Events;

use App\Models\System\User;
use App\Models\System\Valuation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ValuationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User that sent the message
     *
     * @var User
     */
    public $user;

    /**
     * Valuation details
     *
     * @var Valuation
     */
    public $valuation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Valuation $valuation)
    {
        $this->user = $user;
        $this->valuation = $valuation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('valuation');
    }
}
