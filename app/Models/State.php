<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
class State extends Model
{
    use Searchable;

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
