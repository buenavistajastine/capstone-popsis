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

    <div class="row">
        <div class="col-12 col-md-6 col-xl-2">
            <div class="form-group local-forms">
                <label>Year<span class="login-danger">*</span></label>
                <select class="form-control" wire:model="selectedYear">
                    @for ($year = date('Y'); $year >= 2020; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-2">
            <div class="form-group local-forms">
                <label>Month<span class="login-danger">*</span></label>
                <select class="form-control" wire:model="selectedMonth">
                    <option value="">All</option>
                    @for ($month = 1; $month <= 12; $month++)
                        <option value="{{ $month }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-2">
            <div class="form-group local-forms">
                <label>Filter<span class="login-danger">*</span></label>
                <select class="form-control" wire:model="filterType">
                    <option value="all">All</option>
                    <option value="booking">Booking</option>
                    <option value="order">Order</option>
                </select>
            </div>
        </div>
        

    </div>
    <div class="row">
        <!-- Yearly total -->
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <div class="dash-content dash-count">
                    <h4>Yearly Total</h4>
                    @php
                        $yearlyTotal = $transacs->sum('total_amt');
                    @endphp
                    <h2>₱{{ number_format($yearlyTotal, 2) }}</h2>
                </div>
            </div>
        </div>
        
        
        <!-- Monthly total -->
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <div class="dash-content dash-count">
                    <h4>Monthly Total</h4>
                    @php
                        $monthlyTotal = $transactions->sum('total_amt');
                    @endphp
                    <h2 id="monthlyTotal">
                        ₱{{ number_format($monthlyTotal, 2) }}
                    </h2>
                </div>
            </div>
        </div>
        
        {{-- <!-- Weekly total -->
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <div class="dash-content dash-count">
                    <h4>Weekly Total</h4>
                    <h2 id="weeklyTotal">
                        ₱{{ number_format($transactions->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amt'), 2) }}
                    </h2>
                </div>
            </div>
        </div>
        <!-- Daily total -->
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <div class="dash-content dash-count">
                    <h4>Daily Total</h4>
                    @php
                        $dailyTotal = $transactions
                            ->where('created_at', '>=', now()->startOfDay())
                            ->where('created_at', '<=', now()->endOfDay())
                            ->sum('total_amt');
                    @endphp
                    @if ($dailyTotal !== 0)
                        <h2 id="dailyTotal">₱{{ number_format($dailyTotal, 2) }}</h2>
                    @else
                        <p>No transactions for today</p>
                    @endif
                </div>
            </div>
        </div> --}}
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
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success btn-sm mx-1"
                                        wire:click="export" title="Export"> <i class="fa-solid fa-download"></i> Excel Report</button>

                                    </div>
                                    {{-- <div class="doctor-search-blk">
                                        <div class="add-group">
                                            <a class="btn btn-primary ms-2" wire:click="createBooking">
                                                <img alt src="{{ asset('assets/img/icons/plus.svg') }}">
                                            </a>
                                        </div>
                                    </div> --}}
                                </div>
                                {{-- <a href="booking_records" class="ps-4"
                                    style="position: relative; top: -10px;"><small><i>Records</i></small></a> --}}
                            </div>
                            {{-- <div class="col-auto text-end float-end ms-auto download-grp">
                                <div class="top-nav-search table-search-blk">
                                    <form>
                                        <input class="form-control" name="search" placeholder="Search here"
                                            type="text" wire:model.debounce.500ms="search">
                                        <a class="btn"><img alt
                                                src="{{ asset('assets/img/icons/search-normal.svg') }}"></a>
                                    </form>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table border-0 custom-table comman-table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 5px"></th>
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
                                        <td colspan="5" class="text-center">No data available in table.</td>
                                    </tr>
                                @else
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td></td>
                                            <td>
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
                                                    {{ $transaction->bookings['date_event'] ? \Carbon\Carbon::parse($transaction->bookings['created_at'])->format('F j, Y') : '' }}
                                                @elseif ($transaction->foodOrders)
                                                    {{ $transaction->foodOrders['date_need'] ? \Carbon\Carbon::parse($transaction->foodOrders['created_at'])->format('F j, Y') : '' }}
                                                @endif

                                            </td>
                                            <td>
                                                ₱ {{ number_format(optional($transaction)->total_amt, 2) }}
                                            </td>

                                            <td>
                                                {{ optional($transaction->statuses)->name }}

                                            </td>


                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>

                        </table>
                    </div>
                    <tfoot>
                        <div class="d-md-flex align-items-center m-2 p-2">
                            <div class="me-md-auto counterHead text-sm-left text-center mb-2 mb-md-0">
                                Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of
                                {{ $transactions->total() }}
                                entries
                            </div>

                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($transactions->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
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
                                        <a class="page-link" wire:click="nextPage" wire:loading.attr="disabled">Next</a>
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
