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
    public $status = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

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
        $startOfToday = Carbon::now()->startOfDay();

        $records = FoodOrder::whereHas('customers', function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        })
            // ->whereBetween('date_need', [Carbon::parse($this->dateFrom)->startOfDay(), Carbon::parse($this->dateTo)->endOfDay()])
            ->where('date_need', '<', $startOfToday) 
            ->when($this->status, function ($query) {
                $query->where('status_id', $this->status);
            })
            ->orderBy('date_need', 'desc')
            ->paginate(10);

        return view('livewire.food-order.order-record', compact('records'));
    }
}
