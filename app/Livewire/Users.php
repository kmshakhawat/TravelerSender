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
    public $search;

    protected $queryString = ['search'];

    public function render()
    {
        $users = User::role('user')->orderBy('id', 'DESC')->paginate(10);
        $users->load('profile');
        $this->countries = Travel::countries();
        return view('livewire.users',compact('users'));
    }
}
