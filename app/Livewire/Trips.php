<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Trip;
use Livewire\WithPagination;

class Trips extends Component
{
    use WithPagination;
    public $countries;
    public $status_options;
    public $from_country;
    public $to_country;
    public $city;
    public $status;

    protected $queryString = ['from_country', 'to_country', 'city', 'status'];
    public function render()
    {
        if (auth()->user()->hasRole('admin')) {
            $trips = Trip::with(['stopovers'])
                ->when($this->from_country, function ($query) {
                    $query->where('from_country_id', $this->from_country);
                })
                ->when($this->to_country, function ($query) {
                    $query->where('to_country_id', $this->to_country);
                })
                ->when($this->city, function ($query) {
                    $query->where('from_city', 'like', '%' . $this->city . '%')
                        ->orWhere('to_city', 'like', '%' . $this->city . '%');
                })
                ->when($this->status, function ($query) {
                    $query->where('status', $this->status);
                })
                ->orderBy('id', 'DESC')
                ->paginate(10);
        } else {
            $trips = Trip::where('user_id', auth()->user()->id)
                ->with(['stopovers'])
                ->when($this->from_country, function ($query) {
                    $query->where('from_country_id', $this->from_country);
                })
                ->when($this->to_country, function ($query) {
                    $query->where('to_country_id', $this->to_country);
                })
                ->when($this->city, function ($query) {
                    $query->where('from_city', 'like', '%' . $this->city . '%')
                        ->orWhere('to_city', 'like', '%' . $this->city . '%');
                })
                ->when($this->status, function ($query) {
                    $query->where('status', $this->status);
                })
                ->orderBy('id', 'DESC')
                ->paginate(10);
        }
        $this->countries = countries();
        $this->status_options = ['Active'=> 'Active', 'Confirmed' => 'Confirmed', 'In Progress' => 'In Progress', 'Completed' => 'Completed', 'Cancelled' => 'Cancelled'];
        return view('livewire.trip', compact('trips'));
    }
}
