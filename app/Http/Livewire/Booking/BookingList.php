<?php

namespace App\Http\Livewire\Booking;

use Carbon\Carbon;
use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class BookingList extends Component
{
    use WithPagination;

    public $bookingId;
    public $dateFrom;
    public $dateTo;
    public $search = '';

    protected $listeners = [
        'refreshParentBooking' => '$refresh',
        'deleteBooking',
        'editBooking',
        'printDishesByDate',
        'deleteConfirmBooking'
    ];

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when the search term changes
    }

    public function createBooking()
    {
        $this->emit('resetInputFields');
        $this->emit('openBookingModal');
    }


    public function editBooking($bookingId)
    {
        $this->bookingId = $bookingId;
        $this->emit('bookingId', $this->bookingId);
        $this->emit('openBookingModal');
    }

    public function deleteBooking($bookingId)
    {
        Booking::destroy($bookingId);

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }

    public function mount()
    {
        // $this->dateFrom = now()->toDateString();
        $this->dateFrom = Carbon::parse($this->dateFrom)->startOfMonth()->toDateString();
        $this->dateTo = Carbon::parse($this->dateFrom)->endOfMonth()->toDateString();
    }

    // Add a new method to handle printing dishes
    public function printDishesByDate()
    {
        $filteredBookings = Booking::whereBetween('date_event', [
            Carbon::parse($this->dateFrom)->startOfDay(),
            Carbon::parse($this->dateTo)->endOfDay(),
        ])->get();
    
        $this->emit('printDishesByDate', ['filteredBookings' => $filteredBookings]);
    }

    public function render()
    {
        $bookings = Booking::whereHas('customers', function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('event_name', 'like', '%' . $this->search . '%');
            });
        })
            ->whereBetween('date_event', [Carbon::parse($this->dateFrom)->startOfDay(), Carbon::parse($this->dateTo)->endOfDay()])
            ->paginate(10);

        return view('livewire.booking.booking-list', compact('bookings'));
    }
}
