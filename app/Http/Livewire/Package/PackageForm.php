<?php

namespace App\Http\Livewire\Package;

use App\Models\Package;
use App\Models\Venue;
use Livewire\Component;

class PackageForm extends Component
{
    public $packageId, $name, $price, $description, $limitation_of_maindish, $minimum_pax, $venue_id;
    public $action= '';
    public $message= '';

    protected $listeners = [
        'packageId',
        'resetInputFields'
    ];

    public function resetInputFields() {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function packageId($packageId) {
        $this->packageId = $packageId;
        $package = Package::whereId($packageId)->first();
        $this->name = $package->name;
        $this->limitation_of_maindish = $package->limitation_of_maindish;
        $this->price = number_format($package->price, 2);
        $this->description = $package->description;
        $this->minimum_pax = $package->minimum_pax;
        $this->venue_id = $package->venue_id;
    }

    public function store() {
        $data = $this->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'limitation_of_maindish' => 'nullable',
            'minimum_pax' => 'nullable',
            'venue_id' => 'nullable'
        ]);

        

        if($this->packageId) {
            Package::whereId($this->packageId)->first()->update($data);
            $action = 'edit';
            $message = 'Successfully Updated';

        } else {
            Package::create($data);
            $action = 'store';
            $message = 'Successfully Created';
        }

        $this->emit('flashAction', $action, $message);
        $this->resetInputFields();
        $this->emit('closePackageModal');
        $this->emit('refreshParentPackage');
        $this->emit('refreshTable');
    }

    public function render()
    {
        $venues = Venue::all();
        return view('livewire.package.package-form', compact('venues'));
    }
}
