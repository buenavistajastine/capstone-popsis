<?php

namespace App\Http\Livewire\Customer;

use App\Models\User;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterAccountForm extends Component
{
    public $customerId, $first_name, $middle_name, $last_name, $username, $email, $password, $password_confirmation;

    protected $listeners = [
        'customerId',
        'resetInputFields'
    ];

    public function resetInputFields()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function customerId($customerId) 
    {
        $this->customerId = $customerId;
        $customer = Customer::whereId($customerId)->first();

        $this->first_name = $customer->first_name;
        $this->middle_name = $customer->middle_name;
        $this->last_name = $customer->last_name;
        $this->username = null;
        $this->email = null;
    }

    public function store() 
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username,' . ($this->customerId ?? ''),
            'email' => 'required|email|unique:users,email,' . ($this->customerId ?? ''),
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);
        try {
            DB::beginTransaction();
                $userData = [
                    'first_name' => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'last_name' => $this->last_name,
                    'username' => $this->username,
                    'email' => $this->email,
                ];

                if ($this->password) {
                    $userData['password'] = Hash::make($this->password);
                }

                $userData['status_id'] = 12;

                if ($this->customerId) {
                    $user = User::create($userData);
                    $user->assignRole('customer');


                    $customer = Customer::find($this->customerId);
                    $customer->update(['status_id' => 12]);
                    $customer->user_id = $user->id;
                    $customer->save();
                }
                
            DB::commit();
            $this->emit('flashAction', $this->customerId ? 'edit' : 'store', 'Successfully ' . ($this->customerId ? 'Updated' : 'Created'));
            $this->resetInputFields();
            $this->emit('closeCustomerAccountModal');
            $this->emit('refreshParentCustomer');
            $this->emit('refreshTable');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('flashAction', 'error', 'Error: ' . $e->getMessage());
        }
    } 

    public function render()
    {
        return view('livewire.customer.register-account-form');
    }
}
