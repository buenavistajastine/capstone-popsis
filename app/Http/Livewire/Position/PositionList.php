<?php

namespace App\Http\Livewire\Position;

use App\Models\Position;
use Livewire\Component;
use Livewire\WithPagination;

class PositionList extends Component
{
    use WithPagination;
    public $positionId;
    public $search = '';

    protected $listeners = [
        'refreshParentPosition' => '$refresh',
        'deletePosition',
        'editPosition',
        'deleteConfirmPosition'
    ];

    public function updatingSearch()
    {
        $this->emit('refreshTable');
    }

    public function createPosition()
    {
        $this->emit('resetInputFields');
        $this->emit('openPositionModal');
    }

    public function editPosition($positionId)
    {
        $this->positionId = $positionId;
        $this->emit('positionId', $this->positionId);
        $this->emit('openPositionModal');
    }

    public function deletePosition($positionId)
    {
        Position::destroy($positionId);

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }
    public function render()
    {
        $positions = Position::where('name', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.position.position-list', compact('positions'));
    }
}
