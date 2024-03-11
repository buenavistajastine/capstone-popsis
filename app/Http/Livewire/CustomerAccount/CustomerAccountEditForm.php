<?php

namespace App\Http\Livewire\CustomerAccount;

use Exception;
use App\Models\User;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerAccountEditForm extends Component
{
    public $userId, $first_name, $middle_name, $last_name, $username, $email, $password, $password_confirmation;

    // Mount method to handle initialization
    protected $listeners = [
        'userId', // Make sure the event names match
        'resetInputFields',
    ];

    public function resetInputFields()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    // Load user data when editing
    public function userId($userId)
    {
        $this->userId = $userId;
        $user = User::whereId($this->userId)->first();

        $this->first_name = $user->first_name;
        $this->middle_name = $user->middle_name;
        $this->last_name = $user->last_name;
        $this->username = $user->username;
        $this->email = $user->email;
    }

    // Save or update user data
    public function store()
    {
        try {
            DB::beginTransaction();

            $validationRules = [
                'first_name' => 'required',
                'middle_name' => 'nullable',
                'last_name' => 'required',
                'username' => 'required',
                'email' => ['required', 'email'],
            ];

            // If it's an update, only validate the password if it's provided
            if ($this->userId) {
                $validationRules['password'] = ['nullable', 'confirmed', Rules\Password::defaults()];
            } else {
                // For a new user, require password
                $validationRules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
            }

            $this->validate($validationRules);

            if ($this->userId) {
                $data = [
                    'first_name' => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'last_name' => $this->last_name,
                    'username' => $this->username,
                    'email' => $this->email,
                ];

                $user = User::whereId($this->userId)->first();
                $user->update($data);

                $cust = Customer::where('user_id', $this->userId)->first();
                $cust->update([
                    'first_name' => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'last_name' => $this->last_name,
                ]);

                if (!empty($this->password)) {
                    $this->validate([
                        'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
                    ]);

                    $user->update([
                        'password' => Hash::make($this->password),
                    ]);
                }

                $action = 'edit';
                $message = 'Successfully Updated';
            } else {
           
                // For a new user
                $user = User::create([
                    'first_name' => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'last_name' => $this->last_name,
                    'username' => $this->username,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                ]);

                $user->assignRole('customer');

                $action = 'store';
                $message = 'Successfully Created';
            }

            DB::commit();
  

            $this->emit('flashAction', $action, $message);
            $this->resetInputFields();
            $this->emit('closeCustomerAccountEditModal');
            $this->emit('refreshParentCustomerAccount');
            $this->emit('refreshTable');

        } catch (Exception $e) {
            DB::rollBack();
            $errorMessage = $e->getMessage();
            $this->emit('flashAction', 'error', $errorMessage);
        }
    }

    public function render()
    {
        return view('livewire.customer-account.customer-account-edit-form');
    }
}
