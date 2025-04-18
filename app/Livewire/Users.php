<?php

namespace App\Livewire;

use App\Actions\Travel;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    public $countries;
    public $country_id;
    public $city;
    public $search;

    protected $queryString = ['country_id', 'city', 'search'];

    public function render()
    {
        $users = User::role('user')
            ->when($this->country_id, function ($query, $country_id) {
                $query->whereHas('profile', function ($q) use ($country_id) {
                    $q->where('country_id', $country_id);
                });
            })
            ->when($this->search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->when($this->city, function ($query, $city) {
                $query->whereHas('profile', function ($q) use ($city) {
                    $q->where('city', 'like', '%' . $city . '%');
                });
            })

            ->orderBy('id', 'DESC')->paginate(10);


        $users->load('profile');
        $this->countries = countries();
        return view('livewire.users',compact('users'));
    }
}
