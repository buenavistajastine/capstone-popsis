<?php

namespace App\Http\Livewire\FoodOrder;

use App\Models\FoodOrder;
use Carbon\Carbon;
use App\Models\Menu;
use Livewire\Component;
use Livewire\WithPagination;

class OrderReport extends Component
{
    use WithPagination;
    public $search = '';
    public $dateFrom;
    public $dateTo;
    public $totalAmountSum;
    public $selectedOrders = [];
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
        $this->dateFrom = Carbon::parse($this->dateFrom)->startOfMonth()->toDateString();
        $this->dateTo = Carbon::parse($this->dateFrom)->endOfMonth()->toDateString();
    }

    public function updatedSelectAll($value)
    {
        $orders = FoodOrder::with(['orderDish_keys.dishes.menu'])
            ->whereBetween('date_need', [
                Carbon::parse($this->dateFrom)->startOfDay(),
                Carbon::parse($this->dateTo)->endOfDay()
            ])
            ->orderBy('date_need', 'asc')
            ->get();

        if ($value) {
            $this->selectedOrders = $orders->pluck('id')->toArray();
        } else {
            $this->selectedOrders = [];
        }
    }

    public function updatedSelectedOrders()
    {
        $orders = FoodOrder::with(['orderDish_keys.dishes.menu'])
            ->whereBetween('date_need', [
                Carbon::parse($this->dateFrom)->startOfDay(),
                Carbon::parse($this->dateTo)->endOfDay()
            ])
            ->orderBy('date_need', 'asc')
            ->get();

        $totalOrders = count($orders);

        if (count($this->selectedOrders) === $totalOrders) {
            $this->selectAll = true;
        } else {
            $this->selectAll = false;
        }
    }

    public function printOrderDishes()
    {
        $selectedOrders = FoodOrder::with(['orderDish_keys.dishes.menu'])
            ->whereIn('id', $this->selectedOrders)
            ->get();

        $orderDishes = [];
    
        foreach ($selectedOrders as $order) {
            foreach ($order['orderDish_keys'] as $dishKey) {
                $orderDishes[] = [
                    'dish' => $dishKey['dishes'],
                    'quantity' => $dishKey['quantity'],
                ];
            }
        }

        session(['orderDishes' => $orderDishes, 'selectedOrders' => $selectedOrders]);
        
        // return redirect()->route('print.order-dishes');
        $this->emit('openPrintPage');
    }

    public function render()
    {
        $dish_id = [];
    
        $orders = FoodOrder::with(['orderDish_keys.dishes.menu'])
            ->whereBetween('date_need', [
                Carbon::parse($this->dateFrom)->startOfDay(),
                Carbon::parse($this->dateTo)->endOfDay()
            ])
            ->orderBy('date_need', 'asc')
            ->paginate(10);
    
        foreach ($orders as $order) {
            foreach ($order->orderDish_keys as $dish) {
                if (!in_array($dish->dish_id, $dish_id)) {
                    $dish_id[] = $dish->dish_id;
                }
            }
        }
        
        $header = Menu::all();
    
        $this->totalAmountSum = $orders->sum('total_price');

        return view('livewire.food-order.order-report', [
            'orders' => $orders,
            'header' => $header,
            'totalAmountSum' => $this->totalAmountSum
        ]);
    }
}
