<?php

namespace App\Http\Livewire\Billing;

use App\Models\AddOn;
use App\Models\Billing;
use Livewire\Component;
use Livewire\WithPagination;

class BillingList extends Component
{
    use WithPagination;

    public $billingId;
    public $search = '';
    public $action = '';
    public $message = '';
    // public $paymentFilter = '';

    protected $listeners = [
        'refreshParentBilling' => '$refresh',
        'deleteBilling',
        'editBilling',
        'deleteConfirmBilling'
    ];

    public function updatingSearch()
    {
        $this->emit('refreshTable');
    }

    public function editBilling($billingId)
    {
        $this->billingId = $billingId;
        $this->emit('billingId', $this->billingId);
        $this->emit('openBillingModal');
    }

    public function createBilling()
    {
        $this->emit('resetInputFields');
        $this->emit('openBillingModal');
    }

    public function deleteBilling($billingId)
    {
        Billing::destroy($billingId);

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }

    public function render()
{
    $query = Billing::query();

    if (!empty($this->search)) {
        $query->whereHas('customers', function ($query) {
            $query->where('name', 'LIKE', '%' . $this->search . '%');
        });
    }

    $billings = $query->with('bookings.packages', 'bookings.dishess')->paginate(10);

    // dd($billings->pluck('bookings.dishess')->flatten());


    return view('livewire.billing.billing-list', compact('billings'));
}

}
