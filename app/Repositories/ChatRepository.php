<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Models\ChatRecipient;
use Illuminate\Support\Arr;

class ChatRepository
{
    public function create($division, $divisionManagers, $data)
    {
        $chat = Chat::create([
            'division_id' => $division->id,
            'sender_id' => $data['consumer_id'],
            'message' => $data['message'],
        ]);

        $chatReceiver = [];
        foreach ($divisionManagers as $value) {
            $chatData = [];
            $chatData['chat_id'] = $chat->id;
            $chatData['receiver_id'] = $value;
            $chatData['created_at'] = now();
            $chatData['updated_at'] = now();
            array_push($chatReceiver, $chatData);
        }

        ChatRecipient::insert($chatReceiver);

        return $chat;
    }

    public function getMessages($division, $consumer, $noOfRecords)
    {
        return Chat::join('chat_recipients', 'chats.id', '=', 'chat_recipients.chat_id')
            ->leftJoin('consumers', 'consumers.id', '=', 'chats.sender_id')
            ->leftJoin('users', 'users.id', '=', 'consumers.user_id')
            ->join('divisions', 'divisions.id', '=', 'chats.division_id')
            ->select('chats.id', 'chats.sender_id', 'chats.message', 'chats.created_at', 'users.first_name', 'users.last_name')
            ->where('chats.division_id', $division->id)
            ->where(function ($query) use ($consumer) {
                $query->where('chats.sender_id', $consumer)
                    ->orWhere('chat_recipients.receiver_id', $consumer);
            })
            ->orderBy('chats.created_at', 'desc')
            ->groupBy('chats.id')
            ->paginate($noOfRecords);
    }

    public function getUnreadMessageCount($division, $consumer)
    {
        return ChatRecipient::join('chats', 'chats.id', '=', 'chat_recipients.chat_id')
                ->where('chat_recipients.receiver_id', $consumer)
                ->where('chats.division_id', $division->id)
                ->where('is_read', false)
                ->count();
    }

    public function updateUnreadMessage($division, $consumer, $data)
    {
        $query = ChatRecipient::whereIn('chat_id', Chat::where('division_id', $division->id)->pluck('id'));

        if (Arr::get($data, 'current_time')) {
            $query->where('created_at', '<=', $data['current_time']);
        }

        $query->where('receiver_id', $consumer);

        return $query->update(['is_read' => true]);
    }

    public function delete($division, $chat)
    {
        return $chat->delete();
    }
}
