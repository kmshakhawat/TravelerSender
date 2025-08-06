<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

        $users = User::whereIn('id', $chatUsersIds)
            ->get()
            ->map(function ($user) use ($userId) {
                $lastMessage = Message::where(function ($query) use ($user, $userId) {
                    $query->where('sender_id', $user->id)
                        ->where('receiver_id', $userId);
                })
                    ->orWhere(function ($query) use ($user, $userId) {
                        $query->where('sender_id', $userId)
                            ->where('receiver_id', $user->id);
                    })
                    ->latest('created_at')
                    ->first();

                return [
                    'id'                => $user->id,
                    'name'              => $user->name,
                    'profile_photo_url' => $user->profile_photo_url,
                    'last_message'      => optional($lastMessage)->content,
                    'last_message_date' => optional($lastMessage)->created_at,
                ];
            });


        return response()->json([
            'success' => true,
            'users'   => $users,
        ]);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validated->errors()->first(),
            ], 400);
        }
        $data = [
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->message,
        ];

        Message::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
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

