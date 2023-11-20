<?php

namespace App\Http\Livewire\Authentication;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleForm extends Component
{
    public $roleId, $name;
    public $action = '';  //flash
    public $message = '';  //flash

    public $permissions = [];
    public $selectedPerms = [];

    protected $listeners = [
        'roleId',
        'resetInputFields'
    ];

    public function resetInputFields()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }
    
    //edit
    public function roleId($roleId)
    {
        $this->roleId = $roleId;
        $role = Role::find($roleId);
        $this->name = $role->name;
        $this->selectedPerms = array_map('strval' ,json_decode($role->permissions->pluck('id')));
    }

    //store
    public function store()
    {
        if(empty($this->permissions)){
            $this->permissions = array_map('strval', $this->selectedPerms);
        }

        $data = $this->validate([
            'name' => 'required'
        ]);

        if ($this->roleId) {
            $role = Role::find($this->roleId);
            $role->update($data);
            $role->syncPermissions($this->permissions);

            $action = 'edit';
            $message = 'Successfully Updated';

        } else {
            $role = Role::create($data);
            $role->syncPermissions($this->permissions);
            $action = 'store';
            $message = 'Successfully Created';
        }

        $this->emit('flashAction', $action, $message);
        $this->resetInputFields();
        $this->emit('closeRoleModal');
        $this->emit('refreshParentRole');
        $this->emit('refreshTable');
    }

    public function render()
    {
        $perms = Permission::all();
        return view('livewire.authentication.role-form',[
            'perms' => $perms
        ]);
    }
}
