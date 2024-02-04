<?php

namespace App\Http\Livewire\Booking;

use Carbon\Carbon;
use App\Models\Dish;
use App\Models\Menu;
use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class BookingReport extends Component
{
    use WithPagination;
    public $search = '';
    public $dateFrom;
    public $dateTo;
    public $totalAmountSum;
    public $selectedCustomers = [];
    public $selectAll = false;

    public function updatingselectedCompany()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->dateFrom = Carbon::parse($this->dateFrom)->startOfWeek()->toDateString();
        $this->dateTo = Carbon::parse($this->dateFrom)->endOfWeek()->toDateString();
    }

    public function updatedSelectAll($value)
    {
        $bookings = Booking::with(['dish_keys.dishes.menu'])
            ->whereBetween('date_event', [
                Carbon::parse($this->dateFrom)->startOfDay(),
                Carbon::parse($this->dateTo)->endOfDay()
            ])
            ->orderBy('date_event', 'asc')
            ->get();

        if ($value) {
            $this->selectedCustomers = $bookings->pluck('id')->toArray();
        } else {
            $this->selectedCustomers = [];
        }
    }

    public function updatedSelectedCustomers()
    {
        $bookings = Booking::with(['dish_keys.dishes.menu'])
            ->whereBetween('date_event', [
                Carbon::parse($this->dateFrom)->startOfDay(),
                Carbon::parse($this->dateTo)->endOfDay()
            ])
            ->orderBy('date_event', 'asc')
            ->get();

        $totalCustomers = count($bookings);

        if (count($this->selectedCustomers) === $totalCustomers) {
            $this->selectAll = true;
        } else {
            $this->selectAll = false;
        }
    }

    public function printDishes()
    {
        $selectedBookings = Booking::with(['dish_keys.dishes.menu', 'addOns.dishss.menu'])
            ->whereIn('id', $this->selectedCustomers)
            ->get();

        $dishes = [];
    
        foreach ($selectedBookings as $booking) {
            foreach ($booking['dish_keys'] as $dishKey) {
                $dishes[] = [
                    'dish' => $dishKey['dishes'],
                    'quantity' => $dishKey['quantity'],
                ];
            }
    
            foreach ($booking['addOns'] as $addOn) {
                $dishes[] = [
                    'dish' => $addOn['dishss'],
                    'quantity' => $addOn['quantity'],
                ];
            }
        }

        session(['dishes' => $dishes]);
        
        return redirect()->route('print.dishes', compact('dishes'));
    }

    public function render()
    {
        $dish_id = [];
    
        $bookings = Booking::with(['dish_keys.dishes.menu', 'addOns.dishss.menu'])
            ->whereBetween('date_event', [
                Carbon::parse($this->dateFrom)->startOfDay(),
                Carbon::parse($this->dateTo)->endOfDay()
            ])
            ->orderBy('date_event', 'asc')
            ->paginate(10);
    
        foreach ($bookings as $book) {
            foreach ($book->dish_keys as $dish) {
                if (!in_array($dish->dish_id, $dish_id)) {
                    $dish_id[] = $dish->dish_id;
                }
            }
            foreach ($book->addOns as $addOn) {
                if (!in_array($addOn->dishss->id, $dish_id)) {
                    $dish_id[] = $addOn->dishss->id;
                }
            }
        }
    
        $header = Menu::all();
    
        $this->totalAmountSum = $bookings->sum('total_price');
    
        return view('livewire.booking.booking-report', [
            'bookings' => $bookings,
            'header' => $header,
            'totalAmountSum' => $this->totalAmountSum
        ]);
    }
    
}
