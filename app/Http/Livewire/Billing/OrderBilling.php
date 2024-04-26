<?php

namespace App\Http\Livewire\Billing;

use App\Models\Billing;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class OrderBilling extends Component
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
        $tomorrow = Carbon::tomorrow();

        $billings = Billing::with('paidAmount')
            ->whereHas('customers', function ($query) {
                $query->where('first_name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $this->search . '%');
            })
            ->whereNotNull('foodOrder_id')
            ->whereHas('foodOrders', function ($query) use ($tomorrow) {
                $query->whereNotNull('date_need') // Ensure date_need is not null
                    ->where('date_need', '>=', $tomorrow); // Filter bookings with date need greater than or equal to tomorrow
            })
            ->whereNull('booking_id')
            ->with('foodOrders', 'bookings.dishess')
            ->paginate(10);


        return view('livewire.billing.order-billing', compact('billings'));
    }
}
