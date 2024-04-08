<div class="content">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item">All Orders</li>
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
                                    <h3>Order List</h3>
                                    <div class="doctor-search-blk">
                                        <div class="add-group">
                                            <a class="btn btn-primary ms-2" wire:click="createOrder">
                                                <img alt src="{{ asset('assets/img/icons/plus.svg') }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="order_records" class="ps-3" style="position: relative; top: -10px;"><small><i>Records</i></small></a>
                            </div>
                            <div class="col-auto text-end float-end ms-auto download-grp">
                                <div class="top-nav-search table-search-blk">
                                    <form>
                                        <input class="form-control" name="search" placeholder="Search here"
                                            type="text" wire:model.debounce.500ms="search">
                                        <a class="btn"><img alt
                                                src="{{ asset('assets/img/icons/search-normal.svg') }}"></a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
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
                    <div class="table-responsive">
                        <table class="table border-0 custom-table comman-table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Date and Call Time</th>
                                    <th>Address</th>
                                    <th>Transport</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orders->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No data available in table.</td>
                                    </tr>
                                @else
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ ucfirst($order->customers->last_name) }},
                                                {{ ucfirst($order->customers->first_name) }}
                                                {{ $order->customers->middle_name ? ucfirst($order->customers->middle_name) : ''}}</td>
                                            <td>{{ $order['date_need'] ? \Carbon\Carbon::parse($order['date_need'])->format('M j, Y') : '' }}
                                                at
                                                <strong>{{ $order['call_time'] ? \Carbon\Carbon::parse($order['call_time'])->format('g:i A') : '' }}</strong>
                                            </td>
                                 
                                            <td>
                                                <div>
                                                    {{ ucfirst($order->customers->address->barangay) }}, {{ ucfirst($order->customers->address->city) }}
                                                </div>
                                                <div>
                                                    <small>{{ ucfirst($order->customers->address->specific_address) }} ({{ $order->customers->address->landmark }})</small>
                                                </div>
                                            </td>
                                            <td>{{ $order->transports->name }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm mx-1"
                                                        wire:click="editOrder({{ $order->id }})"
                                                        title="Edit"> <i
                                                            class="fa-solid fa-pen-to-square"></i></button>

                                                    <a class="btn btn-danger btn-sm mx-1"
                                                        wire:click="deleteOrder({{ $order->id }})"
                                                        title="Delete"> <i class="fa-solid fa-trash"></i></a>
                                                </div>
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
{{-- Modal --}}
<div wire.ignore.self class="modal fade" id="foodOrderModal" tabindex="-1" aria-labelledby="foodOrderModal"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-top modal-lg">
        <livewire:food-order.food-order-form />
    </div>
</div>


@section('custom_script')
    @include('layouts.scripts.food-order-scripts')
@endsection
