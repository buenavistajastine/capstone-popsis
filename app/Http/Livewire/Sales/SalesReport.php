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

    public function mount()
    {
        $this->selectedYear = Carbon::now()->year;
        $this->selectedMonth = Carbon::now()->month;
        $this->selectedWeek = Carbon::now()->weekOfYear;

    }

    public function render()
    {


        $this->yearlyTotal = Billing::whereYear('created_at', $this->selectedYear)->sum('total_amt');

        $this->monthlyTotal = Billing::whereYear('created_at', $this->selectedYear)
            ->whereMonth('created_at', $this->selectedMonth)
            ->sum('total_amt');

        $this->weeklyTotal = Billing::whereYear('created_at', $this->selectedYear)
            ->whereRaw('WEEK(created_at) = ?', [$this->selectedWeek])
            ->sum('total_amt');

        $this->dailyTotal = Billing::whereDate('created_at', Carbon::today())->sum('total_amt');

        $transactions = Billing::whereYear('created_at', $this->selectedYear);

        if (!empty($this->selectedMonth)) {
            $transactions->whereMonth('created_at', $this->selectedMonth);
        }
        

        if ($this->selectedWeek) {
            $startDate = now()->setISODate($this->selectedYear, $this->selectedWeek)->startOfWeek();
            $endDate = now()->setISODate($this->selectedYear, $this->selectedWeek)->endOfWeek();

            $transactions = $transactions->whereBetween('created_at', [$startDate, $endDate]);
        }


        $transactions = $transactions->paginate(20);

        return view('livewire.sales.sales-report', compact('transactions'));
    }
}
