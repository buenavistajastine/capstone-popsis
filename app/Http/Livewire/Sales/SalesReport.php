<?php

namespace App\Http\Livewire\Sales;

use App\Exports\SalesReportExport;
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
use Maatwebsite\Excel\Facades\Excel;

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

    public function export()
    {
        $transactions = Billing::query();

        if ($this->filterType == 'booking') {
            $transactions->whereNotNull('booking_id');
        } elseif ($this->filterType == 'order') {
            $transactions->whereNotNull('foodOrder_id');
        }

        $transactions->whereYear('created_at', $this->selectedYear);

        if (!empty($this->selectedMonth)) {
            $transactions->whereMonth('created_at', $this->selectedMonth);
        }

        $transactions = $transactions->get();

        $headers = [];
        array_push($headers, 'Transaction ID');
        array_push($headers, 'Customer');
        array_push($headers, 'Date of Transaction');
        array_push($headers, 'Total Amount');
        array_push($headers, 'Status');

        $i = 0;
        $x = 0;
        $data = [];

        $totalOverallPrice = 0;

        foreach ($transactions as $transac) {
            if ($transac->booking_id !== null) {
                $data[$i][$x] = $transac->bookings->booking_no;
            } else {
                $data[$i][$x] = $transac->foodOrders->order_no;
            }
            $x++;
            $data[$i][$x] = $transac->customers->last_name . ', ' . $transac->customers->first_name;
            $x++;
            $data[$i][$x] = $transac->created_at->format('F j, Y');
            $x++;
            $data[$i][$x] = '₱ ' . number_format($transac->total_amt, 2);
            $x++;
            $data[$i][$x] = $transac->statuses->name;
            $i++;
            $totalOverallPrice += $transac->total_amt;
        }
        $data[$i][$x] = '';
        $i++;
        $data[$i][$x] = 'Total Amount:';
        $x++;
        $data[$i][$x] = '';
        $x++;
        $data[$i][$x] = '';
        $x++;
        $data[$i][$x] = '₱ ' . number_format($totalOverallPrice, 2);
        $x++;
        $data[$i][$x] = '';
        $i++;
        $data[$i][$x] = 'Total Transactions:';
        $x++;
        $data[$i][$x] = '';
        $x++;
        $data[$i][$x] = '';
        $x++;
        $data[$i][$x] = count($transactions);
        $x++;
        $data[$i][$x] = '';

        return Excel::download(
            new SalesReportExport($data, $headers),
            'SalesReport.xlsx'
        );
    }
    
    
}
