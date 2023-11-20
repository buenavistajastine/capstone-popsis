<?php

namespace App\Http\Livewire\Employee;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeList extends Component
{
    use WithPagination;

    public $employeeId;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    
    protected $listeners = [
        'refreshParentEmployee' => '$refresh',
        'deleteEmployee',
        'editEmployee',
        'deleteConfirmEmployee'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createEmployee()
    {
        $this->emit('resetInputFields');
        $this->emit('openEmployeeModal');
    }

    public function editEmployee($employeeId)
    {
        $this->employeeId = $employeeId;
        $this->emit('employeeId', $this->employeeId);
        $this->emit('openEmployeeModal');
    }

    public function deleteConfirmEmployee($employeeId)
    {
        $this->dispatchBrowserEvent('confirmEmployeeDelete', [
            'title' => 'Are you sure?',
            'text' => "You won't be able to revert this!",
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonColor' => '#3085d6',
            'cancelButtonColor' => '#d33',
            'confirmButtonText' => 'Yes, delete it!',
            'id' => $employeeId
        ]);
    }

    public function deleteEmployee($employeeId)
    {
        Employee::destroy($employeeId);


        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }

    public function render()
    {
        $employees = Employee::where(function ($query) {
            $query->where('first_name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('middle_name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('contact_no', 'LIKE', '%' . $this->search . '%')
                ->orWhere('address', 'LIKE', '%' . $this->search . '%');
        })
            ->paginate(10);

        return view('livewire.employee.employee-list', compact('employees'));
    }
}
