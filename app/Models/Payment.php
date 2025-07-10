<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;

    protected $hidden = [
        'stripe_session_id',
        'trxref'
    ];
    protected $fillable = [
        'user_id',
        'trip_user_id',
        'booking_id',
        'amount',
        'net_amount',
        'commission',
        'currency',
        'payment_status',
        'stripe_session_id',
        'trxref',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function tripUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trip_user_id', 'id');
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
    public function withdraw(): HasOne
    {
        return $this->hasOne(Withdraw::class);
    }
}
