<div class="content">

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Food Order Report</li>
                </ul>
            </div>
        </div>
    </div>
    <livewire:flash-message.flash-message />
    <div class="row d-flex justify-content-center">
        <div class="col-sm-12">
            <div class="card card-table show-entire">
                <div class="card-body">

                    <div class="page-table-header mb-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="doctor-table-blk">
                                    <h3>Food Order Reports</h3>
                                    <div class="doctor-search-blk">
                                        {{-- <a class="btn btn-primary ms-2" wire:click="exportToExcel"
                                            title="export to Excel">
                                            Audit <i class="fa-solid fa-file-export"></i>
                                        </a>
                                        <a class="btn btn-primary ms-2" wire:click="exportToExcelReport"
                                            title="export to Excel">
                                            Report <i class="fa-solid fa-file-export"></i>
                                        </a> --}}
                                        <a class="btn btn-danger ms-2" title="print dishes" wire:click="printOrderDishes"
                                            target="_blank">
                                            PDF <i class="fa-solid fa-print"></i>
                                        </a>
                                        <div wire:loading wire:target="printDishes" class="text-dark">
                                            Exporting...
                                            Please wait...</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto text-end float-end ms-auto download-grp">
                                <div class="top-nav-search table-search-blk">
                                    <form>
                                        <input type="text" class="form-control" placeholder="Search here"
                                            wire:model.debounce.500ms="search" name="search">
                                        <a class="btn"><img src="assets/img/icons/search-normal.svg" alt></a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1 ms-3 fw-bold">
                            <h5>Filter by:</h5>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group local-forms">
                                <label for="dateFrom">Date From:</label>
                                <input type="date" class="form-control" wire:model="dateFrom" id="dateFrom">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group local-forms">
                                <label for="dateTo">Date To:</label>
                                <input type="date" class="form-control" wire:model="dateTo" id="dateTo">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 ms-3">
                            <h5>
                                Total Amount:
                                <span class="fs-5 fw-bold">
                                    ₱{{ number_format($totalAmountSum, 2) }}
                                </span>
                            </h5>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table border-0 custom-table comman-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 5%">
                                        <input type="checkbox" id="selectAll" wire:model="selectAll"
                                            class="form-check-input checkbox-class">
                                    </th>
                                    <th style="width: 20%">Customer</th>
                                    @if (!empty($orders))
                                        @foreach ($header as $menu)
                                            <th style="width: 10%">{{ $menu->name }}</th>
                                        @endforeach
                                    @endif
                                    <th style="width: 10%">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <input type="checkbox" wire:model="selectedOrders"
                                                value="{{ $order->id }}" class="form-check-input checkbox-class">
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12"><strong>{{ ucfirst($order->customers->last_name) }},
                                                        {{ ucfirst($order->customers->first_name) }}</strong>
                                                </div>
                                                <div class="col-12"><small>#<i>{{ $order->order_no }}</i></small></div>
                                            </div>
                                        </td>
                                        @foreach ($header as $menu)
                                            <td>
                                                @if ($order->orderDish_keys)
                                                    @php
                                                        $mainDishesForMenu = $order->orderDish_keys
                                                            ->filter(function ($dishKey) use ($menu) {
                                                                return $dishKey->dishes->menu_id == $menu->id;
                                                            })
                                                            ->pluck('dishes.name')
                                                            ->implode('<br>');
                                                    @endphp

                                                    @if ($mainDishesForMenu)
                                                        <small>{!! $mainDishesForMenu !!}</small><br>
                                                    @endif
                                                @endif
                                            </td>
                                        @endforeach

                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <strong>
                                                        {{ number_format($order->total_price, 2) }}
                                                    </strong>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <tfoot>
                        <div class="d-md-flex align-items-center m-2 p-2">
                            <div class="me-md-auto counterHead text-sm-left text-center mb-2 mb-md-0">
                                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of
                                {{ $orders->total() }}
                                entries
                            </div>

                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($orders->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage"
                                            wire:loading.attr="disabled">Previous</a></li>
                                @endif

                                @if ($orders->currentPage() > 2)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $orders->currentPage() - 2 }})">{{ $orders->currentPage() - 2 }}</a>
                                    </li>
                                @endif

                                @if ($orders->currentPage() > 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $orders->currentPage() - 1 }})">{{ $orders->currentPage() - 1 }}</a>
                                    </li>
                                @endif

                                <li class="page-item active"><span
                                        class="page-link">{{ $orders->currentPage() }}</span>
                                </li>

                                @if ($orders->hasMorePages())
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $orders->currentPage() + 1 }})">{{ $orders->currentPage() + 1 }}</a>
                                    </li>
                                @endif

                                @if ($orders->currentPage() < $orders->lastPage() - 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $orders->currentPage() + 2 }})">{{ $orders->currentPage() + 2 }}</a>
                                    </li>
                                @endif

                                @if ($orders->hasMorePages())
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

<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        @this.set('selectAll', this.checked);
    });
</script>
