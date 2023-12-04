<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserList extends Component
{
    use WithPagination;
    public $userId;

    public $action = '';  //flash
    public $message = '';  //flash

    public $search = '';

    protected $listeners = [
        'refreshParentUser' => '$refresh',
        'deleteUser',
        'editUser',
        'deleteConfirmUser'
    ];

    public function updatingSearch()
    {
        $this->emit('refreshTable');
    }

    public function createUser()
    {
        $this->emit('resetInputFields');
        $this->emit('openUserModal');
    }

    public function editUser($userId)
    {
        $this->userId = $userId;
        $this->emit('userId', $this->userId);
        $this->emit('openUserModal');
    }

    public function deleteUser($userId)
    {
        User::destroy($userId);

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }

    public function render()
    {
        $usersQuery = User::where(function ($query) {
            $query->where('first_name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('middle_name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                ->orWhere('username', 'LIKE', '%' . $this->search . '%');
        })
        ->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'customer');
        })
        ->paginate(10);

        return view('livewire.user.user-list', [
            'users' => $usersQuery,
        ]);
    }
}
