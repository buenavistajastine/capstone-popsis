<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Gender;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CustomerForm extends Component
{
    use WithFileUploads;
    public $customerId, $first_name, $middle_name, $last_name, $contact_no, $gender_id;
    public $city, $barangay, $specific_address, $landmark;
    public $photo;
    public $photoPath;

    protected $listeners = [
        'customerId',
        'resetInputFields',
        'updatePhotoPreview'
    ];

    public function updatedPhoto($photo)
    {
        $this->validate([
            'photo' => 'image|max:1024', // Example validation rule for image size
        ]);

        $this->emit('photoPreview', $photo->temporaryUrl());
    }

    public function updatePhotoPreview($photoUrl)
    {
        $this->emit('photoPreview', $photoUrl);
    }
    
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
        $customer_address = CustomerAddress::where('customer_id', $customer->id)->first();
        $this->first_name = $customer->first_name;
        $this->middle_name = $customer->middle_name;
        $this->last_name = $customer->last_name;
        $this->contact_no = $customer->contact_no;
        $this->gender_id = $customer->gender_id;
        $this->photo = $customer->photo;

        if ($customer_address) {
            $this->city = $customer_address->city;
            $this->barangay = $customer_address->barangay;
            $this->specific_address = $customer_address->specific_address;
            $this->landmark = $customer_address->landmark;
        } else {
            $this->city = '';
            $this->barangay = '';
            $this->specific_address = '';
            $this->landmark = '';
        }

        $this->photoPath = $customer->photo ? 'upload/images/' . $customer->photo : null;

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
                'city' => 'nullable',
                'barangay' => 'nullable',
                'specific_address' => 'nullable',
                'landmark' => 'nullable',
            ]);

            $address_data = $this->validate([
                'city' => 'nullable',
                'barangay' => 'nullable',
                'specific_address' => 'nullable',
                'landmark' => 'nullable',
            ]);

            $filename = null;
            if ($this->photo instanceof \Illuminate\Http\UploadedFile) {
                $customer = $this->customerId ? Customer::find($this->customerId) : null;

                if ($customer && $customer->photo) {
                    Storage::delete('public/images/' . $customer->photo);
                }

                $filename = date('YmdHi') . '_' . $this->photo->getClientOriginalName();
                $this->photo->storeAs('public/images', $filename);
            } elseif (is_string($this->photo)) {
                // If $this->photo is already a string (file name), no need to process it
                $filename = $this->photo;
            }

            $data['photo'] = $filename;

            if ($this->customerId) {
                $customer = Customer::find($this->customerId);
                $customer->update($data);

                $address = CustomerAddress::where('customer_id', $customer->id)->first();
                $address->update($address_data);

                $action = 'edit';
                $message = 'Customer updated successfully';
            } else {
                $customer = Customer::create($data);
                $address_data['customer_id'] = $customer->id;
                CustomerAddress::create($address_data);

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
