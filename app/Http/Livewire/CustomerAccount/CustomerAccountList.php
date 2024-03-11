<?php

namespace App\Http\Livewire\CustomerAccount;

use App\Models\User;
use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;

class CustomerAccountList extends Component
{
    use WithPagination;
    public $userId;

    public $search = '';

    protected $listeners = [
        'refreshParentCustomerAccount' => '$refresh',
        'deleteCustomerAccount',
        'editCustomerAccount',
        'deleteConfirmCustomerAccount'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // In CustomerAccountList component
    public function editCustomerAccount($userId)
    {
        $this->userId = $userId;
        $this->emit('userId', $this->userId); // Emit the correct event name
        $this->emit('openCustomerAccountEditModal');
    }

    public function deleteCustomerAccount($userId)
    {
        User::destroy($userId);

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }

    public function render()
    {
        $customerAccounts = Customer::with('user')
            ->where('first_name', 'LIKE', "%{$this->search}%")
            ->orWhere('last_name', 'LIKE', "%{$this->search}%")
            ->paginate(10);

        return view('livewire.customer-account.customer-account-list', [
            'customerAccounts' => $customerAccounts,
        ]);
    }
}

