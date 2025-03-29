<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Retrieve all unique user IDs who have interacted with the logged-in user (either as sender or receiver)
        $chatUsersIds = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->pluck('receiver_id')
            ->merge(Message::where('receiver_id', $userId)
                ->pluck('receiver_id'))
            ->unique()
//            ->filter(fn($id) => $id != $userId)  // Exclude the logged-in user
            ->values();

        $users = User::whereIn('id', $chatUsersIds)
            ->get()
            ->map(function ($user) use ($userId) {
                $lastMessage = Message::where(function($query) use ($user, $userId) {
                    $query->where('sender_id', $user->id)
                        ->where('receiver_id', $userId);
                })
                    ->orWhere(function($query) use ($user, $userId) {
                        $query->where('sender_id', $userId)
                            ->where('receiver_id', $user->id);
                    })
                    ->latest()
                    ->first();

                return [
                    'id'               => $user->id,
                    'name'             => $user->name,
                    'profile_photo'    => $user->profile_photo, // Ensure this column exists in your users table
                    'last_message_date' => $lastMessage ? Carbon::parse($lastMessage->created_at)->diffForHumans() : 'No messages',
                ];
            });

        return view('chat', compact('users'));
    }
}

