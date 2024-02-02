<?php

namespace App\Http\Livewire\FoodOrder;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\FoodOrder;

class FoodOrderList extends Component
{
    public $orderId;
    public $dateFrom;
    public $dateTo;
    public $search = '';

    protected $listeners = [
        'refreshParentFoodOrder' => '$refresh',
        'deleteOrder',
        'editOrder',
        'deleteConfirmBooking'
    ];

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when the search term changes
    }
    
    public function createOrder()
    {
        $this->emit('resetInputFields');
        $this->emit('openFoodOrderModal');
    }


    public function editOrder($orderId)
    {
        $this->orderId = $orderId;
        $this->emit('orderId', $this->orderId);
        $this->emit('openFoodOrderModal');
    }

    public function deleteOrder($orderId)
    {
        FoodOrder::destroy($orderId);

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }

    public function mount()
    {
        $this->dateFrom = now()->toDateString();
        $this->dateTo = Carbon::parse($this->dateFrom)->endOfWeek()->toDateString();
    }

    public function render()
    {
        $orders = FoodOrder::whereHas('customers', function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        })
            ->whereBetween('date_need', [Carbon::parse($this->dateFrom)->startOfDay(), Carbon::parse($this->dateTo)->endOfDay()])
            ->paginate(10);

        return view('livewire.food-order.food-order-list', compact('orders'));
    }
}
