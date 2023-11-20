<?php

namespace App\Http\Livewire\Authentication;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionForm extends Component
{
    public $permissionId, $name;
    public $action= '';
    public $message= '';

    protected $listeners = [
        'permissionId',
        'resetInputFields'
    ];

    public function resetInputFields() {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function permissionId($permissionId) {
        $this->permissionId = $permissionId;
        $permission = Permission::whereId($permissionId)->first();
        $this->name = $permission->name;
    }

    public function store() {
        $data = $this->validate([
            'name' => 'required'
        ]);

        if($this->permissionId) {
            Permission::whereId($this->permissionId)->first()->update($data);
            $action = 'edit';
            $message = 'Successfully Updated';

        } else {
            Permission::create($data);
            $action = 'store';
            $message = 'Successfully Created';
        }

        $this->emit('flashAction', $action, $message);
        $this->resetInputFields();
        $this->emit('closePermissionModal');
        $this->emit('refreshParentPermission');
        $this->emit('refreshTable');
    }

    public function closeModal() {
        $this->emit('closePermissionModal');
    }


    public function render()
    {
        return view('livewire.authentication.permission-form');
    }
}
