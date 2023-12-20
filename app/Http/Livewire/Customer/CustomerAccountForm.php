<?php

namespace App\Http\Livewire\Customer;

use App\Models\User;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerAccountForm extends Component
{
    public $customerId, $userId, $customerAccId, $customer_id, $user_id, $first_name, $middle_name, $last_name, $username, $email, $password, $password_confirmation;

    protected $listeners = [
        'customerId',
        'userId',
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
    
        if ($customer) {
            $this->first_name = $customer->first_name;
            $this->middle_name = $customer->middle_name;
            $this->last_name = $customer->last_name;
    
            $cust_acc = User::whereId($customer->user_id)->first();
            if ($cust_acc == null) {
                $this->username = null;
                $this->email = null;
            } else {
                $this->username = $cust_acc->username;
                $this->email = $cust_acc->email;
            }
        }
    }
    
    // public function userId($userId)
    // {
    //     $this->userId = $userId;
    //     $customer = User::whereId($userId)->first();
    
    //     if ($customer) {
    //         $this->first_name = $customer->first_name;
    //         $this->middle_name = $customer->middle_name;
    //         $this->last_name = $customer->last_name;
    //         $this->username = $customer->username;
    //         $this->email = $customer->email;
    //     }
    // }
    

    public function store()
    {
        $validationRules = [
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'username' => 'required',
            'email' => ['required', 'email'],
        ];
    
        if ($this->userId) {
            $validationRules['email'][] = Rule::unique('users', 'email')->ignore($this->userId);
        } else {
            $validationRules['email'][] = Rule::unique('users', 'email');
        }
    
        if ($this->userId || !empty($this->password)) {
            $validationRules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }
    
        $this->validate($validationRules);
    
        try {
            DB::beginTransaction();
    
            if ($this->userId) {
                $this->updateUser();
                $action = 'edit';
                $message = 'Successfully Updated';
            } else {
                $this->createUser();
                $action = 'store';
                $message = 'Successfully Created';
            }
    
            DB::commit();
    
            $this->emit('flashAction', $action, $message);
            $this->resetInputFields();
            $this->emit('closeCustomerAccountModal');
            $this->emit('refreshParentCustomer');
            $this->emit('refreshTable');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('flashAction', 'error', 'Error: ' . $e->getMessage());
        }
    }
    
    protected function updateUser()
    {
        $data = [
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
        ];

        $user = User::find($this->userId);
        $user->update($data);

        if (!empty($this->password)) {
            $this->validate([
                'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            ]);

            $user->update([
                'password' => Hash::make($this->password),
            ]);
        }
    }

    protected function createUser()
    {
        // For a new user
        $user = User::create([
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Assign the 'customer' role to the user
        $user->assignRole('customer');

        $customer = Customer::find($this->customerId);

        $customer->user_id = $user->id;
        $customer->save();
    }

    public function render()
    {
        return view('livewire.customer.customer-account-form');
    }
}
