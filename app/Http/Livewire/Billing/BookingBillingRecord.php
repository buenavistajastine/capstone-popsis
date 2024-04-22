<?php

namespace App\Http\Livewire\Billing;

use App\Models\Billing;
use Livewire\Component;
use Livewire\WithPagination;

class BookingBillingRecord extends Component
{
    use WithPagination;

    public $billingId;
    public $search = '';
    public $action = '';
    public $message = '';

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
        $query = Billing::with(['bookings.packages', 'bookings.dishess'])
            ->whereNotNull('booking_id');

        if (!empty($this->search)) {
            $query->whereHas('customers', function ($query) {
                $query->where(function ($query) {
                    $query->where('first_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('middle_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $this->search . '%');
                });
            });
        }

        $billings = $query->paginate(10);

        return view('livewire.billing.booking-billing-record', compact('billings'));
    }
}
