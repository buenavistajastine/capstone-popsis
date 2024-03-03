<?php

namespace App\Http\Livewire\Activity;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Component
{
    use WithPagination;
    public $search = '';

    public function updatingSearch()
    {
        $this->emit('refreshTable');
    }
    
    public function render()
    {
        $activities = Activity::where('log_name', 'like', '%' . $this->search . '%')
                            ->orWhere('description', 'like', '%' . $this->search . '%')
                            ->orWhere('event', 'like', '%' . $this->search . '%')
                            ->orWhere('properties', 'like', '%' . $this->search . '%')
                            ->paginate(10);
        
        return view('livewire.activity.activity-log', compact('activities'));
    }
}
