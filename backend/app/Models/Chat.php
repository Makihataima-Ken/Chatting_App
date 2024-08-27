<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chat extends Model
{
    use HasFactory;

    // Mass Assignable Attributes
    protected $table="chats";
    protected $guarded = [
        'id'
    ];

    //get 'em participants
    public function participants(): HasMany
    {
        return $this->hasMany(ChatParticipant::class, 'chat_id');
    }

    //get 'em messages
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'chat_id');
    }

    // get last message
    public function lastmessage(): HasOne
    {
        return $this->hasOne(ChatMessage::class, 'chat_id')->latest('updated_at');
    }

    //check for participants
    public function scopeHasParticipants($query,int $userid)
    {
        return $query->whereHas('participants',function($q) use($userid){$q->where('user_id',$userid);});
    }
}
