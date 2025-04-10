<?php

namespace App\Livewire;

use App\Models\Trip;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class TripSearch extends Component
{
    use WithPagination;

    public $from;
    public $to;
    public $departure_date;
    public $shorting;
    public $departure_filter;
    public $review;

    protected $queryString = ['from', 'to', 'departure_date', 'shorting', 'departure_filter', 'review'];

    public function resetForm()
    {
        $this->reset(['from', 'to', 'departure_date', 'shorting', 'departure_filter']);
    }

    public function render()
    {
        $trips = Trip::when($this->from, function ($query) {
            $query->where('from_city', 'like', '%' . $this->from . '%');
            $query->orWhereHas('fromCountry', function ($query) {
                $query->where('name', 'like', '%' . $this->from . '%');
            });
        })
            ->when($this->to, function ($query) {
                $query->where('to_city', 'like', '%' . $this->to . '%');
                $query->orWhereHas('toCountry', function ($query) {
                    $query->where('name', 'like', '%' . $this->to . '%');
                });
            })
            ->when($this->departure_date, function ($query) {
                $query->whereDate('departure_date', Carbon::parse($this->departure_date)->format('Y-m-d'));
            })
            ->where('status', 'Active')
            ->where('user_id', '!=', auth()->id())
            ->when($this->shorting, function ($query) {
                switch ($this->shorting) {
                    case 'lowest_price':
                        $query->orderBy('price', 'ASC');
                        break;
                    case 'highest_price':
                        $query->orderBy('price', 'DESC');
                        break;
                    case 'highest_reward':
                        $query->orderBy('reward', 'DESC');
                        break;
                    default:
                        $query->orderBy('departure_date', 'ASC'); // Default
                        break;
                }
            })
            ->when($this->departure_filter, function ($query) {
                switch ($this->departure_filter) {
                    case 'today':
                        $query->whereDate('departure_date', Carbon::today());
                        break;
                    case 'tomorrow':
                        $query->whereDate('departure_date', Carbon::tomorrow());
                        break;
                    case 'this_week':
                        $query->whereBetween('departure_date', [Carbon::now(), Carbon::now()->addWeek()]);
                        break;
                    case '15_days':
                        $query->whereBetween('departure_date', [Carbon::now(), Carbon::now()->addDays(15)]);
                        break;
                    case 'this_month':
                        $query->whereBetween('departure_date', [Carbon::now(), Carbon::now()->addMonth()]);
                        break;
                    default:
                        $query->where('departure_date', '>=', Carbon::now());
                        break;
                }
            })
            ->when($this->review, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->whereHas('ratings', function ($r) {
                        $r->where('rating', '>=', $this->review);
                    });
                });
            })
            ->where('departure_date', '>=', Carbon::now())
            ->orderBy('departure_date', 'ASC')
            ->with('user')
            ->paginate(10);

        return view('livewire.trip-search', compact('trips'));
    }
}
