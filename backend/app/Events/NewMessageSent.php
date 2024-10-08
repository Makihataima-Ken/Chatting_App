<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * new massage sent constructor.
     */
    public function __construct(private ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.'.$this->chatMessage->chat_id),
        ];
    }
    /**
     * broadcast's events name
     */
    public function broadcastAs():string
    {
        return 'message.sent';
    }
    /**
     * data sent back to the client
     */
    public function broadcastWith():array
    {
        return[
            'chat_id'=>$this->chatMessage->chat_id,
            'message'=>$this->chatMessage->toArray(),
        ];
    }
}
