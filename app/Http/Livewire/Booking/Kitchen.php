<?php

namespace App\Http\Livewire\Booking;

use Carbon\Carbon;
use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class Kitchen extends Component
{
    use WithPagination;
    public $search = '';
    public $dateFrom;
    public $dateTo;


    public function mount()
    {
        $this->dateFrom = Carbon::parse($this->dateFrom)->startOfYear()->toDateString();
        $this->dateTo = Carbon::parse($this->dateFrom)->endOfYear()->toDateString();
    }

    public function render()
    {
        $bookings = Booking::with(['dish_keys.dishes.menu', 'addOns.dishss.menu', 'customers'])
        ->whereBetween('date_event', [
            Carbon::parse($this->dateFrom)->startOfDay(),
            Carbon::parse($this->dateTo)->endOfDay()
        ])
        ->orderBy('call_time', 'asc')
        ->paginate(10);

        // dd($bookings);
        
        return view('livewire.booking.kitchen', compact('bookings'));
    }
}
