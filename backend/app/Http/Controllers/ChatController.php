<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetChatRequest;
use App\Http\Requests\StoreChatRequest;
use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    /**
     * gets chats
     * Display a listing of the resource.
     */
    public function index(GetChatRequest $request):JsonResponse
    {
        $data=$request->validated();
        $is_private = (int)$data['is_private'] ?? 1; // Default to 1 if not set

        $chats=Chat::where('is_private',$is_private)
            ->hasParticipant(auth()->user()->id)
            ->whereHas('messages')
            ->with('lastMessage.user','participants.user')
            ->latest('updated_at')
            ->get();
        
        return $this->success($chats);
    }

    /**
     * Store a newly created data of a chat in storage.
     */
    public function store(StoreChatRequest $request):JsonResponse
    {
        $data=$this->prepareStoredData($request);

        if($data['userId']==$data['otherUserId']){
            return $this->error('you can not make a chat with thy self');
        }

        $previousChat=$this->getPreviousChat($data['otherUserId']);

        if($previousChat==null){
            $chat=Chat::create($data['data']);
            $chat->participants()->createMnay(['user_id'=>$data['userId']],['user_id'=>$data['otherUserId']],);
            $chat->refresh()->load('last_message.user','participants,user');
            return $this-> success($chat);
        }
        return $this-> success($previousChat->load('last_message.user','participants,user'));
    }
    /**
     * 
     * check 
     */
    private function getPreviousChat(int $otherUserId):mixed
    {
        $userId=auth()->user()->id;

        return Chat::where('is_private',1)
            ->whereHas('participants',function($query)use($userId){$query->where('user_id',$userId);})
            ->whereHas('participants',function($query)use($otherUserId){$query->where('user_id',$otherUserId);})
            ->first();
    }

    /**
     * prepares the data for storing
     */
    private function prepareStoredData(StoreChatRequest $request)
    {
        $data=$request->validated();
        $otherUserId=(int)$data['user_id'];
        unset($data['user_id']);
        $data['created_by']=auth()->user()->id;

        return[
            'otherUserId'=>$otherUserId,
            'userId'=>auth()->user()->id,
            'data'=>$data,
        ];
    }



    /**
     * get a single chat
     * Display the specified resource.
     */
    public function show(Chat $chat): JsonResponse
    {
        $chat->load('lastMessage.user','participants.user');
        return $this->success($chat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
