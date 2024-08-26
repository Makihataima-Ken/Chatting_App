<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use HasFactory;

    // Mass Assignable Attributes
    protected $table="chat_messages";
    protected $guarded = [
        'id'
    ];
    protected $touches=['chat'];

    //every chat_message has a user
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    //every chat_message has a chat
    public function chat():BelongsTo
    {
        return $this->belongsTo(Chat::class,'chat_id');
    }

}
