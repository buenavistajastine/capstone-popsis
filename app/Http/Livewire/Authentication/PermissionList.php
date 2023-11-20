<?php

namespace App\Http\Livewire\Authentication;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionList extends Component
{
    use WithPagination;
    public $permissionId;
    public $search = '';

    protected $listeners = [
        'refreshParentPermission' => '$refresh',
        'deletePermission',
        'editPermission',
        'deleteConfirmPermission'
    ];

    public function updatingSearch()
    {
        $this->emit('refreshTable');
    }

    public function createPermission()
    {
        $this->emit('resetInputFields');
        $this->emit('openPermissionModal');
    }

    public function editPermission($permissionId)
    {
        $this->permissionId = $permissionId;
        $this->emit('permissionId', $this->permissionId);
        $this->emit('openPermissionModal');
    }

    public function deletePermission($permissionId)
    {
        Permission::destroy($permissionId);

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }

    public function render()
    {
        $permissions = Permission::where('name', 'like', '%' . $this->search . '%')->paginate(10);

        return view('livewire.authentication.permission-list', compact('permissions'));
    }
}
