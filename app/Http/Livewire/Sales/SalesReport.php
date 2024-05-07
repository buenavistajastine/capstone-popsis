<?php

namespace App\Http\Livewire\Sales;

use App\Models\Billing;
use App\Models\Booking;
use App\Models\FoodOrder;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;



class SalesReport extends Component
{

    use WithPagination;
    public $yearlyTotal;
    public $monthlyTotal;
    public $weeklyTotal;
    public $dailyTotal;
    public $selectedYear;
    public $selectedMonth;
    public $selectedWeek;
    public $weeksInMonth;
    public $filterType = 'all';

    public function mount()
    {
        $this->selectedYear = Carbon::now()->year;
        $this->selectedMonth = Carbon::now()->month;
        $this->selectedWeek = Carbon::now()->weekOfYear;

    }

    public function render()
    {
        $transactions = Billing::query();
    
        // Apply filter based on transaction type
        if ($this->filterType == 'booking') {
            $transactions->whereNotNull('booking_id');
        } elseif ($this->filterType == 'order') {
            $transactions->whereNotNull('foodOrder_id');
        }
    
        // Filter by year
        $transactions->whereYear('created_at', $this->selectedYear);
        $this->yearlyTotal = $transactions->sum('total_amt');
    
        // Filter by month if selected
        if (!empty($this->selectedMonth)) {
            $transactions->whereMonth('created_at', $this->selectedMonth);
            // Recalculate yearly total after applying month filter
            $this->yearlyTotal = $transactions->sum('total_amt');
            // Recalculate monthly total after applying month filter
            $this->monthlyTotal = $transactions->sum('total_amt');
        }
    
        // Paginate the transactions
        $transactions = $transactions->paginate(20);
    
        return view('livewire.sales.sales-report', compact('transactions'));
    }
    
}
