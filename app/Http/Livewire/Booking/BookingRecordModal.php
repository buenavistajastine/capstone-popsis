<?php

namespace App\Http\Livewire\Booking;

use Carbon\Carbon;
use App\Models\Booking;
use Livewire\Component;
use App\Models\BookingDishKey;

class BookingRecordModal extends Component
{
    public $recordId;

    public function render()
    {
        $bookings = Booking::with(['dish_keys.dishes.menu', 'addOns.dishss.menu'])
            ->orderBy('date_event', 'asc')
            ->paginate(10);

        return view('livewire.booking.booking-record-modal', compact('bookings'));
    }
}
