<?php

namespace App\Http\Livewire\FoodOrder;

use App\Events\OrderCreated;
use App\Models\Billing;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\FoodOrder;
use Livewire\WithPagination;

class FoodOrderList extends Component
{
    use WithPagination;
    public $orderId;
    public $dateFrom;
    public $dateTo;
    public $search = '';
    public $status = '';

    protected $listeners = [
        'refreshTable' => '$refresh',
        'refreshParentFoodOrder' => '$refresh',
        'deleteOrder',
        'editOrder',
        'deleteConfirmBooking',
        'acceptOrder' => 'acceptOrder',
        'cancelOrder' => 'cancelOrder'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
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
        // $this->dateFrom = now()->toDateString();
        $this->dateFrom = Carbon::parse($this->dateFrom)->startOfMonth()->toDateString();
        $this->dateTo = Carbon::parse($this->dateFrom)->endOfMonth()->toDateString();
    }

    public function acceptOrder($orderId)
    {
        $order = FoodOrder::find($orderId);

        if ($order) {
            $order->update(['status_id' => 2]);
            event(new OrderCreated($order));

            $this->emit('flashAction', 'store', 'Order accepted successfully.');
        } else {
            $this->emit('flashAction', 'error', 'Order not found.');
        }

        $this->emit('refreshTable');
    }

    public function cancelOrder($orderId)
    {
        $order = FoodOrder::find($orderId);
        $billing = Billing::where('foodOrder_id', $orderId)->first();

        if ($order) {
            $order->update(['status_id' => 3]);
            $billing->update(['status_id' => 3]);

            // event(new OrderCreated($order));
            $this->emit('flashAction', 'store', 'Order cancelled successfully.');
        } else {
            $this->emit('flashAction', 'error', 'Order not found.');
        }

        $this->emit('refreshTable');
    }

    public function render()
    {
        $startOfToday = Carbon::now()->startOfDay(); // Start of today

        $orders = FoodOrder::whereHas('customers', function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        })
            ->where('date_need', '>=', $startOfToday)
            ->whereBetween('date_need', [Carbon::parse($this->dateFrom)->startOfDay(), Carbon::parse($this->dateTo)->endOfDay()])
            ->when($this->status, function ($query) {
                $query->where('status_id', $this->status);
            })
            ->orderBy('date_need') // Order by event date
            ->orderBy('call_time') // Then order by call time
            ->paginate(10);

        return view('livewire.food-order.food-order-list', compact('orders'));
    }
}
