<?php

namespace App\Http\Livewire\Package;

use App\Models\Package;
use Livewire\Component;
use Livewire\WithPagination;

class PackageList extends Component
{
    use WithPagination;
    public $packageId;
    public $search = '';

    protected $listeners = [
        'refreshParentPackage' => '$refresh',
        'deletePackage',
        'editPackage',
        'deleteConfirmPackage'
    ];

    public function updatingSearch()
    {
        $this->emit('refreshTable');
    }

    public function createPackage()
    {
        $this->emit('resetInputFields');
        $this->emit('openPackageModal');
    }

    public function editPackage($packageId)
    {
        $this->packageId = $packageId;
        $this->emit('packageId', $this->packageId);
        $this->emit('openPackageModal');
    }

    public function deletePackage($packageId)
    {
        Package::destroy($packageId);

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }

    public function render()
    {
        $packages = Package::where('name', 'like', '%' . $this->search . '%')->get();

        return view('livewire.package.package-list', compact('packages'));
    }
}
