<?php

namespace App\Http\Livewire\FoodOrder;

use App\Models\FoodOrder;
use Livewire\Component;

class FoodOrderList extends Component
{
    public $orderId;
    public $search = '';

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

    public function render()
    {
        $orders = FoodOrder::whereHas('customers', function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        })
            ->paginate(10);

        return view('livewire.food-order.food-order-list', compact('orders'));
    }
}
