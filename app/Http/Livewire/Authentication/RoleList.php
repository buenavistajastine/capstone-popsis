<?php

namespace App\Http\Livewire\Authentication;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleList extends Component
{
    use WithPagination;

    public $roleId;
    public $search = '';
    public $action = '';  //flash
    public $message = '';  //flash

    protected $listeners = [
        'refreshParentRole' => '$refresh',
        'deleteRole',
        'editRole',
        'deleteConfirmRole',
        'refreshTable' => 'render', // listen to refreshTable event
    ];

    public function createRole()
    {
        $this->emit('resetInputFields');
        $this->emit('openRoleModal');
    }

    public function editRole($roleId)
    {
        $this->roleId = $roleId;
        $this->emit('roleId', $this->roleId);
        $this->emit('openRoleModal');
    }

    public function deleteRole($roleId)
    {
        Role::destroy($roleId);

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }

    public function render()
    {
        $roles = Role::where('name', 'like', '%' . $this->search . '%')
            ->paginate(10); // You can adjust the number of items per page

        return view('livewire.authentication.role-list', [
            'roles' => $roles,
        ]);
    }
}
