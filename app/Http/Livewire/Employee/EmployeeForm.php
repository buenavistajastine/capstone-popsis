<?php

namespace App\Http\Livewire\Employee;

use App\Models\CivilStatus;
use App\Models\Employee;
use App\Models\Gender;
use App\Models\Position;
use Carbon\Carbon;
use Livewire\Component;

class EmployeeForm extends Component
{
    public $employeeId, $first_name, $middle_name, $last_name, $birthdate, $age, $gender, $address, $contact_no, $photo, $civil_status_id, $position_id;
    
    protected $listeners = [
        'employeeId',
        'resetInputFields'
    ];

    public function resetInputFields()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function employeeId($employeeId)
    {
        $this->employeeId = $employeeId;
        $employee = Employee::whereId($employeeId)->first();
        $this->first_name = $employee->first_name;
        $this->middle_name = $employee->middle_name;
        $this->last_name = $employee->last_name;
        $this->birthdate = $employee->birthdate;
        $this->age = $employee->age;
        $this->contact_no = $employee->contact_no;
        $this->gender = $employee->gender_id;
        $this->address = $employee->address;
        $this->photo = $employee->photo;
        $this->civil_status_id = $employee->civil_status_id;
        $this->position_id = $employee->position_id;
    }

    public function store()
    {
        $this->validate([
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'birthdate' => 'required',
            'age' => 'nullable',
            'contact_no' => 'nullable',
            'gender' => 'required',
            'address' => 'required',
            'photo' => 'nullable',
            'civil_status_id' => 'required',
            'position_id' => 'required',
        ]);

        $bday = Carbon::parse($this->birthdate);
        $today = Carbon::now();
        $dif = $bday->diff($today);

        if($this->employeeId) {
            $employee = Employee::find($this->employeeId);
            $employee->update([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'birthdate' => $this->birthdate,
                'age' => $dif->y,
                'contact_no' => $this->contact_no,
                'gender_id' => $this->gender,
                'address' => $this->address,
                // 'photo' => $this->photo,
                'civil_status_id' => $this->civil_status_id,
                'position_id' => $this->position_id
            ]);
        } else {
            Employee::create([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'birthdate' => $this->birthdate,
                'age' => $dif->y,
                'contact_no' => $this->contact_no,
                'gender_id' => $this->gender,
                'address' => $this->address,
                // 'photo' => $this->photo,
                'civil_status_id' => $this->civil_status_id,
                'position_id' => $this->position_id
            ]);
        }

        $this->emit('flashAction', 'store', 'Successfully Updated');
        $this->resetInputFields();
        $this->emit('closeEmployeeModal');
        $this->emit('refreshParentEmployee');
        $this->emit('refreshTable');

    }

    public function render()
    {
        $genders = Gender::all();
        $civil_statuses = CivilStatus::all();
        $positions = Position::all();

        return view('livewire.employee.employee-form', compact('genders', 'civil_statuses', 'positions'));
    }
}
