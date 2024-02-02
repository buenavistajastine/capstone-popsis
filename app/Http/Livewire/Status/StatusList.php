<?php

namespace App\Http\Livewire\Status;

use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;

class StatusList extends Component
{
    use WithPagination;
    public $statusId;
    public $search = '';

    protected $listeners = [
        'refreshParentStatus' => '$refresh',
        'deleteStatus',
        'editStatus',
        'deleteConfirmStatus'
    ];

    public function updatingSearch()
    {
        $this->emit('refreshTable');
    }

    public function createStatus()
    {
        $this->emit('resetInputFields');
        $this->emit('openStatusModal');
    }

    public function editStatus($statusId)
    {
        $this->statusId = $statusId;
        $this->emit('statusId', $this->statusId);
        $this->emit('openStatusModal');
    }

    public function deleteStatus($statusId)
    {
        Status::destroy($statusId);

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }

    public function render()
    {
        $statuses = Status::where('name', 'like', '%' . $this->search . '%')->paginate(10);

        return view('livewire.status.status-list', compact('statuses'));
    }
}
