<?php

namespace App\Http\Controllers;

use App\Events\NewMessageSent;
use App\Http\Requests\GetMessageRequest;
use App\Http\Requests\StoreMessageRequest;
use App\Models\ChatMessage;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{   
    /**
     * gets chat messages
     */
    public function index(GetMessageRequest $request){
        $data=$request->validated();
        $chatId=$data['chat_id'];
        $currentPage=$data['page'];
        $pageSize=$data['page_size']??15;

        $messages=ChatMessage::where('chat_id',$chatId)
            ->with('user')
            ->latest('created_at')
            ->simplePaginate($pageSize,['*'],'page',$currentPage);
            
        return $this->success($messages->getCollection());
    }
    /**
     * creates and stores messages
     */
    public function store(StoreMessageRequest $request){
        $data=$request->validated();
        $data['chat_id']=auth()->user()->id;

        $chatMessage=ChatMessage::create($data);
        $chatMessage->load('user');

        /// TODO send broadcast event to pusher and send notification to onesignal service
        $this->sendNotificatioToOthers($chatMessage);

        return $this->success($chatMessage,'message has been sent');

    }
    /**
     * notitifys other users
     */
    public function sendNotificatioToOthers(ChatMessage $chatMessage):void
    {
        $chatId=$chatMessage->chat_id;

        broadcast(new NewMessageSent($chatMessage))->toOthers();

        $user=auth()->user();
        $userId=$user->id;

        $chat=Chat::where('id',$chatMessage->chat_id)
                ->with(['participants'=>function($query) use($userId)
                {$query->where('user_id','!=',$userId);} 
            ])->first();

        if(count($chat->participants)>0){
            $otherUserId=$chat->participants[0]->user_id;
            $otherUser=User::where('id',$otherUserId)->first();
            $otherUser->sendNotificatioToOthers([
                'messageData'=>[
                    'senderName'=>$user->username,
                    'message'=>$chatMessage->message,
                    'chat_id'=>$chatId,
                ]
            ]);
        }    
    }
}
