<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerList extends Component
{
    use WithPagination;

    public $customerId;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    protected $listeners = [
        'refreshParentCustomer' => '$refresh',
        'deleteCustomer',
        'editCustomer',
        'deleteConfirmCustomer'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createCustomer()
    {
        $this->emit('resetInputFields');
        $this->emit('openCustomerModal');
    }

    public function createCustomerAccount($customerId)
    {
        $this->customerId = $customerId;
        $this->emit('resetInputFields');
        $this->emit('customerId', $this->customerId);
        $this->emit('openCustomerAccountModal');
    }

    // public function editCustomerAccount($user_id)
    // {
    //     $this->user_id = $user_id;
    //     $this->emit('resetInputFields');
    //     $this->emit('customerId', $this->user_id);
    //     $this->emit('openCustomerAccountModal');
    // }

    public function editCustomer($customerId)
    {
        $this->customerId = $customerId;
        $this->emit('customerId', $this->customerId);
        $this->emit('openCustomerModal');
    }

    public function deleteCustomer($customerId)
    {
        Customer::destroy($customerId);

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }
    
    public function render()
    {
        $customers = Customer::where(function ($query) {
            $query->where('first_name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('middle_name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('contact_no', 'LIKE', '%' . $this->search . '%');
        })
                ->paginate(10);

        return view('livewire.customer.customer-list', compact('customers'));
    }
}
