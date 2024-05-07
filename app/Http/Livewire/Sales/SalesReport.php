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
    
        if ($this->filterType == 'booking') {
            $transactions->whereNotNull('booking_id');
        } elseif ($this->filterType == 'order') {
            $transactions->whereNotNull('foodOrder_id');
        }
    
        $transactions->whereYear('created_at', $this->selectedYear);
        $yearlyTotal = $transactions->sum('total_amt');
    
        if (!empty($this->selectedMonth)) {
            $transactions->whereMonth('created_at', $this->selectedMonth);
        }
    
        $monthlyTotal = $transactions->sum('total_amt');
            $transactions = $transactions->paginate(20);
    

        $transacs = Billing::query();
        if ($this->filterType == 'booking') {
            $transacs->whereNotNull('booking_id');
        } elseif ($this->filterType == 'order') {
            $transacs->whereNotNull('foodOrder_id');
        }

        $transacs->whereYear('created_at', $this->selectedYear);
        $yearlyTotals = $transacs->sum('total_amt');

        // dd($yearlyTotals);
        return view('livewire.sales.sales-report', [
            'transactions' => $transactions,
            'transacs' => $transacs,
            'yearlyTotal' => $yearlyTotal, // Pass the yearly total to the view
            'monthlyTotal' => $monthlyTotal, // Also pass the monthly total if needed
        ]);
    }
    
    
}
