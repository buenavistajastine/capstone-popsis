<?php

namespace App\Http\Livewire\Activity;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Component
{
    use WithPagination;
    public $search = '';
    public $dateFrom;
    public $dateTo;

    protected $listeners = [
        'refreshParentBooking' => '$refresh',
        'deleteBooking',
        'editBooking',
        'printDishesByDate',
        'deleteConfirmBooking'
    ];

    public function updatingSearch()
    {
        $this->emit('refreshTable');
    }

    public function mount()
    {
        $this->dateFrom = Carbon::now()->startOfMonth()->toDateString();
        $this->dateTo = Carbon::now()->endOfMonth()->toDateString();
    }


    public function render()
    {
        $activities = Activity::whereBetween('created_at', [$this->dateFrom, $this->dateTo])
            ->where(function ($query) {
                $query->where('log_name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('event', 'like', '%' . $this->search . '%')
                    ->orWhere('properties', 'like', '%' . $this->search . '%');
            })
            
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        return view('livewire.activity.activity-log', compact('activities'));
    }
}
