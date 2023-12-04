<?php

namespace App\Http\Livewire\Booking;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class BookingList extends Component
{
    use WithPagination;
    
    public $bookingId;
    public $search = '';

    protected $listeners = [
        'refreshParentBooking' => '$refresh',
        'deleteBooking',
        'editBooking',
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

    public function render()
    {
        $bookings = Booking::whereHas('customers', function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        })
            ->paginate(10);

        return view('livewire.booking.booking-list', compact('bookings'));
    }
}
