<?php

namespace App\Http\Livewire\Billing;

use App\Models\Billing;
use Livewire\Component;
use Livewire\WithPagination;

class OrderBillingRecord extends Component
{
    use WithPagination;

    public $orderBillingId;
    public $search = '';
    public $action = '';
    public $message = '';

    protected $listeners = [
        'refreshParentOrderBilling' => '$refresh',
        'deleteOrderBilling',
        'editOrderBilling',
        'deleteConfirmOrderBilling'
    ];

    public function updatingSearch()
    {
        $this->emit('refreshTable');
    }

    public function editOrderBilling($orderBillingId)
    {
        $this->orderBillingId = $orderBillingId;
        $this->emit('orderBillingId', $this->orderBillingId);
        $this->emit('openOrderBillingModal');
    }

    // public function createBilling()
    // {
    //     $this->emit('resetInputFields');
    //     $this->emit('openBillingModal');
    // }

    public function deleteBilling($orderBillingId)
    {
        Billing::destroy($orderBillingId);

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }


    public function render()
    {

        $billings = Billing::whereHas('customers', function ($query) {
            $query->where('first_name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('middle_name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $this->search . '%');
        })
            ->whereNotNull('foodOrder_id')
            ->whereNull('booking_id')
            ->with('foodOrders', 'bookings.dishess')
            ->paginate(10);

        return view('livewire.billing.order-billing-record', compact('billings'));
    }
}
