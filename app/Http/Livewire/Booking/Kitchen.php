<?php

namespace App\Http\Livewire\Booking;

use Carbon\Carbon;
use App\Models\AddOn;
use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BookingDishKey;

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

    public function updateStatus($bookingDishKeyId)
    {
        $bookingDishKey = BookingDishKey::findOrFail($bookingDishKeyId);
        $bookingDishKey->update(['status_id' => $bookingDishKey->status_id == 1 ? 6 : 1]);

    }

    public function updateAddOns($addOnId) {
        $addOn = AddOn::findOrFail($addOnId);
        $addOn->update(['status_id' => $addOn->status_id == 1 ? 6 : 1]);
    }

    
    public function render()
    {
        $bookings = Booking::with(['dish_keys.dishes.menu', 'addOns.dishss', 'customers'])
        ->whereBetween('date_event', [
            Carbon::parse($this->dateFrom)->startOfDay(),
            Carbon::parse($this->dateTo)->endOfDay()
        ])
        ->orderBy('call_time', 'asc')
        ->get();
        
        return view('livewire.booking.kitchen', compact('bookings'));
    }
}
