<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetMessageRequest;
use App\Http\Requests\StoreMessageRequest;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

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

        return $this->success($chatMessage,'message has been sent');

    }
}
