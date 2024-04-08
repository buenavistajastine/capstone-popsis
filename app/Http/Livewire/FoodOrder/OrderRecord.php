<?php

namespace App\Http\Livewire\FoodOrder;

use App\Models\FoodOrder;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class OrderRecord extends Component
{
    use WithPagination;
    public $dateFrom;
    public $dateTo;
    public $search = '';
    public $orderRecordId;

    public function mount()
    {
        $this->dateFrom = Carbon::parse($this->dateFrom)->startOfMonth()->toDateString();
        $this->dateTo = Carbon::parse($this->dateFrom)->endOfMonth()->toDateString();
    }
    
    public function orderDetails($orderRecordId)
    {
        $this->orderRecordId = $orderRecordId;
        // dd($this->recordId);
        $this->emit('orderRecordId', $orderRecordId);
        $this->emit('openOrderRecordModal');
    }

    public function render()
    {
        $records = FoodOrder::with('orderDish_keys')
        ->whereBetween('date_need', [
            Carbon::parse($this->dateFrom)->startOfDay(),
            Carbon::parse($this->dateTo)->endOfDay()
        ])
        ->orderBy('date_need', 'asc')
        ->paginate(10);

        return view('livewire.food-order.order-record', compact('records'));
    }
}
