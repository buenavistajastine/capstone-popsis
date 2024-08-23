<div class="content">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item">Sales Report</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card report-card">
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-md-12">
                    <ul class="app-listing">
                        <li>
                            <div>
                                <div class="form-group local-forms">
                                    <label>Year</label>
                                    <select class="form-control" wire:model="selectedYear">
                                        @for ($year = date('Y'); $year >= 2020; $year--)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div>
                                <div class="form-group local-forms">
                                    <label>Month</label>
                                    <select class="form-control" wire:model="selectedMonth">
                                        <option value="">All</option>
                                        @for ($month = 1; $month <= 12; $month++)
                                            <option value="{{ $month }}">
                                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div>
                                <div class="form-group local-forms">
                                    <label>Filter</label>
                                    <select class="form-control" wire:model="filterType">
                                        <option value="all">All</option>
                                        <option value="booking">Booking</option>
                                        <option value="order">Order</option>
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div>
                                <div class="form-group local-forms">
                                    <label>Status</label>
                                    <select class="form-control" wire:model="statusType">
                                        <option value="all">All</option>
                                        <option value="paid">Paid</option>
                                        <option value="partial">Partially Paid</option>
                                        <option value="unpaid">Unpaid</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="report-btn">
                                <a href="#" class="btn" wire:click="export">
                                    <img src="assets/img/invoices-icon5.png" alt="" class="me-2">
                                    Generate report
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card inovices-card">
                <div class="card-body">
                    <div class="inovices-widget-header">
                        @php
                            $yearlyTotal = $transacs
                                // ->whereDoesntHave('statuses', function ($query) {
                                //     $query->where('status_id', 3);
                                // })
                                ->sum('total_amt');
                            $yearlyCount = $transacs
                                ->count();
                        @endphp
                        <span class="inovices-widget-icon">
                            <img src="assets/img/invoices-icon1.svg" alt="">
                        </span>
                        <div class="inovices-dash-count">
                            <div class="inovices-amount">₱{{ number_format($yearlyTotal, 2) }}</div>
                        </div>
                    </div>
                    <p class="inovices-all">Yearly Total <span>{{ $yearlyCount }}</span></p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card inovices-card">
                <div class="card-body">
                    <div class="inovices-widget-header">
                        @php
                            $monthlyTotal = $transactions->sum('total_amt');
                            $monthlyCount = $transactions->count();
                            
                        @endphp
                        <span class="inovices-widget-icon">
                            <img src="assets/img/invoices-icon2.svg" alt="">
                        </span>
                        <div class="inovices-dash-count">
                            <div class="inovices-amount">₱{{ number_format($monthlyTotal, 2) }}</div>
                        </div>
                    </div>
                    <p class="inovices-all">Monthly Total <span>{{ $monthlyCount }}</span></p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card inovices-card">
                <div class="card-body">
                    <div class="inovices-widget-header">
                        @php
                            $unpaidTotal = $transactions->where('status_id', 6)->sum('total_amt');

                            $unpaidCount = $transactions->where('status_id', 6) ->count();
                        @endphp
                        <span class="inovices-widget-icon">
                            <img src="assets/img/invoices-icon3.svg" alt="">
                        </span>
                        <div class="inovices-dash-count">
                            <div class="inovices-amount">₱{{ number_format($unpaidTotal, 2) }}</div>
                        </div>
                    </div>
                    <p class="inovices-all">Unpaid Invoices <span>{{ $unpaidCount }}</span></p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card inovices-card">
                <div class="card-body">
                    <div class="inovices-widget-header">
                        @php
                            $calcelledTotal = $transactions->where('status_id', 3)->sum('total_amt');

                            $cancelledCount = $transactions->where('status_id', 3) ->count();
                        @endphp
                        <span class="inovices-widget-icon">
                            <img src="assets/img/invoices-icon4.svg" alt="">
                        </span>
                        <div class="inovices-dash-count">
                            <div class="inovices-amount">₱{{ number_format($calcelledTotal, 2) }}</div>
                        </div>
                    </div>
                    <p class="inovices-all">Cancelled Invoices <span>{{ $cancelledCount }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-sm-12">
            <div class="card card-table show-entire">
                <div class="card-body">
                    <div class="page-table-header mb-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="doctor-table-blk">
                                    <h3>Sales Report</h3>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-table">
                                <div class="card-body p-4">
                                    <div class="table-responsive">
                                        <table class="table custom-table comman-table mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Transaction ID</th>
                                                    <th>Customer</th>
                                                    <th>Date of Transaction</th>
                                                    <th>Total Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($transactions->isEmpty())
                                                    <tr>
                                                        <td colspan="6" class="text-center">No data available in
                                                            table.</td>
                                                    </tr>
                                                @else
                                                    @foreach ($transactions as $transaction)
                                                        <tr>

                                                            <td class="text-info">
                                                                @if ($transaction->bookings)
                                                                    #{{ $transaction->bookings->booking_no }}
                                                                @elseif ($transaction->foodOrders)
                                                                    #{{ $transaction->foodOrders->order_no }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $transaction->customers->first_name }},
                                                                {{ $transaction->customers->last_name }}
                                                            </td>
                                                            <td>
                                                                @if ($transaction->bookings)
                                                                    {{ $transaction->bookings['date_event'] ? \Carbon\Carbon::parse($transaction->bookings['created_at'])->format('d M Y') : '' }}
                                                                @elseif ($transaction->foodOrders)
                                                                    {{ $transaction->foodOrders['date_need'] ? \Carbon\Carbon::parse($transaction->foodOrders['created_at'])->format('d M Y') : '' }}
                                                                @endif

                                                            </td>
                                                            <td class="text-primary">
                                                                ₱
                                                                {{ number_format(optional($transaction)->total_amt, 2) }}
                                                            </td>

                                                            <td>
                                                                @if ($transaction->status_id == 6 || $transaction->status_id == 3)
                                                                    <span
                                                                        class="badge bg-danger-light">{{ optional($transaction->statuses)->name }}</span>
                                                                @elseif ($transaction->status_id == 13)
                                                                    <span
                                                                        class="badge bg-primary-light">{{ optional($transaction->statuses)->name }}</span
                                                                    @else <span
                                                                        class="badge bg-success-light">{{ optional($transaction->statuses)->name }}</span>
                                                                @endif
                                                            </td>


                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>

                                        </table>

                                    </div>
                                </div>
                                <tfoot>
                                    <div class="d-md-flex align-items-center ms-4 me-4">
                                        <div class="me-md-auto counterHead text-sm-left text-center mb-2 mb-md-0">
                                            Showing {{ $transactions->firstItem() }} to
                                            {{ $transactions->lastItem() }} of
                                            {{ $transactions->total() }}
                                            entries
                                        </div>

                                        <ul class="pagination pagination-separated mb-0 justify-content-center">
                                            @if ($transactions->onFirstPage())
                                                <li class="page-item disabled"><span class="page-link">Previous</span>
                                                </li>
                                            @else
                                                <li class="page-item"><a class="page-link" wire:click="previousPage"
                                                        wire:loading.attr="disabled">Previous</a></li>
                                            @endif

                                            @if ($transactions->currentPage() > 2)
                                                <li class="page-item"><a class="page-link"
                                                        wire:click="gotoPage({{ $transactions->currentPage() - 2 }})">{{ $transactions->currentPage() - 2 }}</a>
                                                </li>
                                            @endif

                                            @if ($transactions->currentPage() > 1)
                                                <li class="page-item"><a class="page-link"
                                                        wire:click="gotoPage({{ $transactions->currentPage() - 1 }})">{{ $transactions->currentPage() - 1 }}</a>
                                                </li>
                                            @endif

                                            <li class="page-item active"><span
                                                    class="page-link">{{ $transactions->currentPage() }}</span>
                                            </li>

                                            @if ($transactions->hasMorePages())
                                                <li class="page-item"><a class="page-link"
                                                        wire:click="gotoPage({{ $transactions->currentPage() + 1 }})">{{ $transactions->currentPage() + 1 }}</a>
                                                </li>
                                            @endif

                                            @if ($transactions->currentPage() < $transactions->lastPage() - 1)
                                                <li class="page-item"><a class="page-link"
                                                        wire:click="gotoPage({{ $transactions->currentPage() + 2 }})">{{ $transactions->currentPage() + 2 }}</a>
                                                </li>
                                            @endif

                                            @if ($transactions->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" wire:click="nextPage"
                                                        wire:loading.attr="disabled">Next</a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link">Next</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </tfoot>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
