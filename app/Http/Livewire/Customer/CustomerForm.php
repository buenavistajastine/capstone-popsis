<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use App\Models\Gender;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CustomerForm extends Component
{
    public $customerId, $first_name, $middle_name, $last_name, $contact_no, $gender_id;

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
        $this->contact_no = $customer->contact_no;
        $this->gender_id = $customer->gender_id;
    }

    public function store()
    {
        try {
            DB::beginTransaction();

            $data = $this->validate([
                'first_name' => 'required',
                'middle_name' => 'nullable',
                'last_name' => 'required',
                'contact_no' => 'nullable',
                'gender_id' => 'nullable',
            ]);

            if ($this->customerId) {
                $customer = Customer::find($this->customerId);
                $customer->update($data);

                $action = 'edit';
                $message = 'Customer updated successfully';
            } else {
                Customer::create($data);

                $action = 'store';
                $message = 'Customer created successfully';
            }
            DB::commit();

            $this->emit('flashAction', $action, $message);
            $this->resetInputFields();
            $this->emit('closeCustomerModal');
            $this->emit('refreshParentCustomer');
            $this->emit('refreshTable');
        } catch (Exception $e) {
            DB::rollBack();
            $errorMessage = $e->getMessage();
            $this->emit('flashAction', 'error', $errorMessage);
        }
    }
    public function render()
    {
        $genders = Gender::all();
        return view('livewire.customer.customer-form', compact('genders'));
    }
}
