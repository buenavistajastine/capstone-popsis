<?php

namespace App\Http\Livewire\Booking;

use Carbon\Carbon;
use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class BookingRecord extends Component
{
    use WithPagination;
    public $recordId;
    public $dateFrom;
    public $dateTo;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when the search term changes
    }

    public function mount()
    {
        $this->dateFrom = Carbon::parse($this->dateFrom)->startOfMonth()->toDateString();
        $this->dateTo = Carbon::parse($this->dateFrom)->endOfMonth()->toDateString();
    }

    public function bookingDetails($recordId)
    {
        $this->recordId = $recordId;
        // dd($this->recordId);
        $this->emit('recordId', $recordId);
        $this->emit('openBookingRecordModal');
    }

    public function render()
    {
        $records = Booking::with('dish_keys')
        ->whereHas('customers', function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('event_name', 'like', '%' . $this->search . '%');
            });
        })
        ->whereBetween('date_event', [
            Carbon::parse($this->dateFrom)->startOfDay(),
            Carbon::parse($this->dateTo)->endOfDay()
        ])
        ->orderBy('date_event', 'asc')
        ->paginate(10);
        
        return view('livewire.booking.booking-record', compact('records'));
    }
}
