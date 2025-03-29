<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'content', 'is_read'];



    public function scopeUnread($query, $userId, $otherUserId)
    {
        return $query->where('receiver_id', $userId)
            ->where('sender_id', $otherUserId)
            ->where('is_read', false);
    }

    // Mark the message as read
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Define the relationship with the receiver (User who received the message)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
