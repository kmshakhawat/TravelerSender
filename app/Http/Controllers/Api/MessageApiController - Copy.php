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

        $relatedUserIds = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->get()
            ->flatMap(function ($message) use ($userId) {
                return [
                    $message->sender_id,
                    $message->receiver_id,
                ];
            })
            ->unique()
            ->reject(fn($id) => $id == $userId)
            ->values();

        $threads = [];

        foreach ($relatedUserIds as $partnerId) {
            $partner = User::find($partnerId);

            $messages = Message::where(function ($query) use ($userId, $partnerId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $partnerId);
            })->orWhere(function ($query) use ($userId, $partnerId) {
                $query->where('sender_id', $partnerId)
                    ->where('receiver_id', $userId);
            })
                ->orderBy('created_at', 'asc')
                ->get();

            $threads[] = [
                'user' => [
                    'id' => $partner->id,
                    'name' => $partner->name,
                    'email' => $partner->email,
                ],
                'messages' => $messages,
            ];
        }

        return response()->json([
            'success' => true,
            'data'   => $threads,
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
            'message' => $request->message,
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
    public function show($userId)
    {
        $authId = Auth::id();

        // Prevent self-chat
        if ($authId == $userId) {
            return response()->json(['error' => 'Cannot view messages with yourself.'], 400);
        }

        // Find the partner user
        $partner = User::find($userId);
        if (!$partner) {
            return response()->json([
                'success' => false,
                'error' => 'User not found.'
            ], 404);
        }

        // Get all messages between the authenticated user and the partner
        $messages = Message::where(function ($query) use ($authId, $userId) {
            $query->where('sender_id', $authId)
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($authId, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $authId);
        })
            ->orderBy('created_at', 'ASC')
            ->get();

        return response()->json([
            'partner' => [
                'id' => $partner->id,
                'name' => $partner->name,
                'email' => $partner->email,
            ],
            'messages' => $messages,
        ]);
    }
}

