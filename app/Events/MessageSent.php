<?php

namespace App\Events;

use App\Models\Store\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\System\User;
use App\Models\System\Message;



class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_receiver;
    public $user_seder;
    public $message;

    /**
     * Create a new event instance.
     *
    "status": "Message Sent!"

     * @return void
     */
    public function __construct(User $user_receiver, User $user_seder, Message $message)
    {
        $this->user_receiver = $user_receiver;
        $this->user_seder = $user_seder;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.'.$this->user_receiver->id);//.$this->user->id
    }
}
