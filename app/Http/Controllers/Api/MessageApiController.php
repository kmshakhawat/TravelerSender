<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MessageApiController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Retrieve all unique user IDs who have interacted with the logged-in user (either as sender or receiver)
        $chatUsersIds = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->pluck('receiver_id')
            ->merge(Message::where('receiver_id', $userId)
                ->pluck('sender_id'))
            ->unique()
            ->values();

        // Get the users who have interacted with the logged-in user
        $users = User::whereIn('id', $chatUsersIds)
            ->get()
            ->map(function ($user) use ($userId) {
                // Get the last message for each conversation
                $lastMessage = Message::where(function ($query) use ($user, $userId) {
                    $query->where('sender_id', $user->id)
                        ->where('receiver_id', $userId);
                })
                    ->orWhere(function ($query) use ($user, $userId) {
                        $query->where('sender_id', $userId)
                            ->where('receiver_id', $user->id);
                    })
                    ->latest()
                    ->first();

                return [
                    'id'               => $user->id,
                    'name'             => $user->name,
                    'profile_photo'    => $user->profile_photo,  // Ensure this column exists in your users table
                    'last_message'     => $lastMessage ? $lastMessage->message : 'No messages',
                    'last_message_date' => $lastMessage ? Carbon::parse($lastMessage->created_at)->diffForHumans() : 'No messages',
                ];
            });

        return response()->json([
            'success' => true,
            'users'   => $users,
        ]);
    }

    /**
     * Get all messages in a conversation (thread) between the logged-in user and a specified receiver.
     */
    public function loadMessages($receiverId)
    {
        if (!$receiverId) {
            return response()->json([
                'success' => false,
                'message' => 'Receiver ID is required.',
            ], 400);
        }

        $userId = Auth::id();

        // Retrieve the conversation between the logged-in user and the specified receiver
        $messages = Message::where(function ($query) use ($receiverId, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $receiverId);
        })
            ->orWhere(function ($query) use ($receiverId, $userId) {
                $query->where('sender_id', $receiverId)
                    ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark unread messages as read
        $unread = $messages->where('receiver_id', $userId)->whereNull('read_at');
        foreach ($unread as $msg) {
            $msg->update(['read_at' => now()]);
        }

        return response()->json([
            'success'  => true,
            'messages' => $messages,
        ]);
    }
}

