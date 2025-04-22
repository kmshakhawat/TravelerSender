<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Middleware\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'email_verified_at',
        'currency_id',
        'country_id',
        'password',
        'status',
        'profile_photo_path',
        'verified',
        'otp',
        'otp_verified',
        'otp_expiry',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfiles::class);
    }


    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'sender_id')
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at');
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class, 'sender_id')
            ->orWhere('receiver_id', $this->id)
            ->latest('created_at');
    }
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Define the relationship for messages received by the user
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function ratings() {
        return $this->hasMany(Rating::class, 'traveler_id');
    }

    public function averageRating() {
        return number_format($this->ratings()->avg('rating'), 1);
    }


    public function earnings()
    {
        return $this->hasMany(Payment::class, 'trip_user_id')
            ->whereHas('booking', function ($query) {
                $query->where('status', 'Completed');
            })
            ->where('payment_status', 'paid')
            ->sum('net_amount');
    }
    public function commission()
    {
        return $this->hasMany(Payment::class)
            ->where('payment_status', 'paid')
            ->sum('commission');
    }

    public function hasValidOtp()
    {
        return $this->otp_verified == 1 &&
            $this->otp_expiry !== null &&
            $this->otp_expiry > now();
    }

}
