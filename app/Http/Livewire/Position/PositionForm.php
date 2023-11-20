<?php

namespace App\Http\Livewire\Position;

use App\Models\Position;
use Livewire\Component;

class PositionForm extends Component
{
    public $positionId, $name;
    public $action = '';
    public $message = '';

    protected $listeners = [
        'positionId',
        'resetInputFields'
    ];

    public function resetInputFields()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function positionId($positionId)
    {
        $this->positionId = $positionId;
        $position = Position::whereId($positionId)->first();
        $this->name = $position->name;
    }

    public function store()
    {
        $data = $this->validate([
            'name' => 'required'
        ]);

        if($this->positionId) {
            Position::whereId($this->positionId)->first()->update($data);
            $action = 'edit';
            $message = 'Successfully Updated';
        } else {
            Position::create($data);
            $action = 'store';
            $message = 'Successfully Created';
        }

        $this->emit('flashAction', $action, $message);
        $this->resetInputFields();
        $this->emit('closePositionModal');
        $this->emit('refreshParentPosition');
        $this->emit('refreshTable');
    }

    public function render()
    {
        return view('livewire.position.position-form');
    }
}
