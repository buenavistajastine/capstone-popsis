<?php

namespace App\Http\Livewire\FoodOrder;

use App\Models\FoodOrder;
use Livewire\Component;
use Livewire\WithPagination;

class OrderRecordModal extends Component
{
    use WithPagination;

    public $orderRecordId;

    protected $listeners = ['orderRecordId' => 'setOrderRecordId'];

    public function setOrderRecordId($orderRecordId)
    {
        $this->orderRecordId = $orderRecordId;
    }

    public function render()
    {
        $order = FoodOrder::with(['orderDish_keys.dishes.menu', 'customers', 'billing.statuses'])
        ->whereId($this->orderRecordId)
        ->orderBy('date_need', 'asc')
        ->first();

        // dd($order);
        return view('livewire.food-order.order-record-modal', compact('order'));
    }
}
