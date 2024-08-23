<?php

namespace App\Http\Livewire\Booking;

use App\Events\BookingCreated;
use App\Models\Billing;
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
    public $status = '';

    protected $listeners = [
        'refreshTable' => '$refresh',
        'refreshParentBooking' => '$refresh',
        'deleteBooking',
        'editBooking',
        'printDishesByDate',
        'deleteConfirmBooking',
        'acceptBooking' => 'acceptBooking',
        'cancelBooking' => 'cancelBooking',
        'reBooking' => 'reBooking',

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

    public function acceptBooking($bookingId)
    {
        $booking = Booking::find($bookingId);

        if ($booking) {
            $booking->update(['status_id' => 2]);
            event(new BookingCreated($booking));

            $this->emit('flashAction', 'store', 'Booking accepted successfully.');
        } else {
            $this->emit('flashAction', 'error', 'Booking not found.');
        }

        $this->emit('refreshTable');
    }

    public function cancelBooking($bookingId)
    {

        $booking = Booking::find($bookingId);
        $billing = Billing::where('booking_id', $bookingId)->first();

        if ($booking) {
            $booking->update(['status_id' => 3]);
            $billing->update(['status_id' => 3]);

            // event(new BookingCreated($booking));
            $this->emit('flashAction', 'store', 'Booking cancelled successfully.');
        } else {
            $this->emit('flashAction', 'error', 'Booking not found.');
        }

        $this->emit('refreshTable');
    }

    public function render()
    {
        $startOfToday = Carbon::now()->startOfDay(); // Start of today

        $bookings = Booking::whereHas('customers', function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('event_name', 'like', '%' . $this->search . '%');
            });
        })
            ->where('date_event', '>=', $startOfToday) // Only upcoming bookings
            ->when($this->status, function ($query) {
                $query->where('status_id', $this->status);
            })
            ->orderBy('date_event') // Order by event date
            ->orderBy('call_time') // Then order by call time
            ->paginate(10); 

        return view('livewire.booking.booking-list', compact('bookings'));
    }
}
