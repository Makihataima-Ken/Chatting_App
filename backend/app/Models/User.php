<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\MessageSent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table="users";
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    const USER_TOKEN="usertoken";

    //not sure about this part yet
    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'created_by');
    }

    public function routeNotificationForOneSignal():array
    {
        return['tags'=>[
            'key'=>'user_id',
            'relation'=>'=',
            'value'=>(string)($this->id)
            ]];
    }

    public function sendNewMessageNotification(array $data)
    {
        return $this->notify(new MessageSent($data));
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
