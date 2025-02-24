<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfiles extends Model
{
    protected $fillable = [
        'user_id',
        'dob',
        'address_1',
        'address_2',
        'city',
        'state',
        'postcode',
        'id_type',
        'id_number',
        'id_issue',
        'id_expiry',
        'id_front',
        'id_back',
        'photo',
    ];
}
