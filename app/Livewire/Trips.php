<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Trip;

class Trips extends Component
{
    public function render()
    {
        $trips = Trip::all();
        return view('livewire.trip', compact('trips'));
    }
}
