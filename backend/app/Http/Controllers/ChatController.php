<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetChatRequest;
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
