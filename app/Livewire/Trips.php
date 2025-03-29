<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Trip;

class Trips extends Component
{
    public function render()
    {
        if (auth()->user()->hasRole('admin')) {
            $trips = Trip::with(['stopovers'])
            ->orderBy('id', 'DESC')
                ->paginate(10);
        } else {
            $trips = Trip::where('user_id', auth()->user()->id)
            ->with(['stopovers'])
            ->orderBy('id', 'DESC')
                ->paginate(10);
        }
        return view('livewire.trip', compact('trips'));
    }
}
