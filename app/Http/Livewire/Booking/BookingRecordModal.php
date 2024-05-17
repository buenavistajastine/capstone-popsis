<?php

namespace App\Http\Livewire\Booking;

use Carbon\Carbon;
use App\Models\Booking;
use Livewire\Component;
use App\Models\BookingDishKey;
use App\Models\Customer;

class BookingRecordModal extends Component
{
    public $recordId;

    protected $listeners = ['recordId' => 'setRecordId'];

    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;
    }

    public function render()
    {
        $booking = Booking::with(['dish_keys.dishes.menu', 'addOns.dishss.menu', 'customers', 'billing.statuses'])
            ->whereId($this->recordId)
            ->orderBy('date_event', 'asc')
            ->first();

        return view('livewire.booking.booking-record-modal', compact('booking'));
    }
}
