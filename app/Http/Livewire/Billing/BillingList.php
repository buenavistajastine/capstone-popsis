<?php

namespace App\Http\Livewire\Billing;

use App\Models\AddOn;
use App\Models\Billing;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class BillingList extends Component
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
        $tomorrow = Carbon::tomorrow(); // Get tomorrow's date

        $query = Billing::with(['bookings.packages', 'bookings.dishess', 'paidAmount'])
            ->whereNotNull('booking_id')
            ->whereHas('bookings', function ($query) use ($tomorrow) {
                $query->whereNotNull('date_event') // Ensure date_event is not null
                    ->where('date_event', '>=', $tomorrow); // Filter bookings with date event greater than or equal to tomorrow
            })
            ->orderBy('created_at', 'desc');

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
// dd($billings);
        return view('livewire.billing.billing-list', compact('billings'));
    }
}
