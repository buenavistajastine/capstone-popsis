<div class="content">
    <div class="page-header">
        <div class="row justify-content-space-between">
            <div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item"><a href="order">All Orders</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item">Food Order Records</li>
                </ul>
            </div>
            <div>

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
                                    <h3>Order Records</h3>
                                </div>
                                <a onclick="goBack()" href="order" style="position: relative;"><small><i
                                            class="fa-solid fa-arrow-left"></i> <i>Back</i></small></a>
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
                        <div class="col-md-2">
                            <div class="form-group local-forms">
                                <label for="statusFilter">Status:</label>
                                <select class="form-control" id="statusFilter" wire:model="status">
                                    <option value="">All</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Approved</option>
                                    <option value="3">Cancelled</option>
                                    <option value="11">Completed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table border-0 custom-table comman-table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Action</th>



                                </tr>
                            </thead>
                            <tbody>
                                @if ($records->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No data available in table.</td>
                                    </tr>
                                @else
                                    @foreach ($records as $record)
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12 mb-1 text-justify fw-bold">
                                                        @if ($record->customers)
                                                            {{ ucwords($record->customers->last_name) }},
                                                            {{ ucwords($record->customers->first_name) }}
                                                            {{ $record->customers->middle_name ? ucfirst($record->customers->middle_name) : '' }}
                                                        @else
                                                            No customer data
                                                        @endif
                                                    </div>
                                                    <div class="col-12"><small>#{{ $record->order_no }}</small>
                                                    </div>
                                                    {{-- <div class="col-md-12 mb-1 text-sm">
                                                        #{{ $record->record_no }}
                                                    </div> --}}
                                                </div>
                                            </td>
                                            <td>
                                                {{ $record['date_need'] ? \Carbon\Carbon::parse($record['date_need'])->format('F j, Y') : '' }}
                                                at
                                                <strong>{{ $record['call_time'] ? \Carbon\Carbon::parse($record['call_time'])->format('g:i A') : '' }}</strong>
                                            </td>
                                            <td>
                                                @php
                                                    $address = $record->customers->address;
                                                @endphp
                                                <div class="row">
                                                    <div class="col-md-12 mb-1 text-justify">
                                                        <small>{{ ucfirst($address->specific_address) }}</small>
                                                    </div>
                                                    <div class="col-md-12 mb-1">

                                                        {{ ucfirst($address->barangay) }}, {{ ucfirst($address->city) }}

                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($record->status_id == 1)
                                                    <button
                                                        class="custom-badge status-orange">{{ $record->statuses->name }}</button>
                                                @elseif ($record->status_id == 2)
                                                    <button
                                                        class="custom-badge status-green">{{ $record->statuses->name }}</button>
                                                @elseif ($record->status_id == 3)
                                                    <button class="custom-badge status-pink">
                                                        {{ $record->statuses->name }}</button>
                                                @elseif ($record->status_id == 11)
                                                    <button class="custom-badge status-blue">
                                                        {{ $record->statuses->name }}</button>
                                                @endif
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm mx-1"
                                                    wire:click="orderDetails({{ $record->id }})" title="View"> <i
                                                        class="fa-solid fa-list-check"></i></button>
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
                                Showing {{ $records->firstItem() }} to {{ $records->lastItem() }} of
                                {{ $records->total() }}
                                entries
                            </div>

                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($records->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage"
                                            wire:loading.attr="disabled">Previous</a></li>
                                @endif

                                @if ($records->currentPage() > 2)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $records->currentPage() - 2 }})">{{ $records->currentPage() - 2 }}</a>
                                    </li>
                                @endif

                                @if ($records->currentPage() > 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $records->currentPage() - 1 }})">{{ $records->currentPage() - 1 }}</a>
                                    </li>
                                @endif

                                <li class="page-item active"><span
                                        class="page-link">{{ $records->currentPage() }}</span>
                                </li>

                                @if ($records->hasMorePages())
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $records->currentPage() + 1 }})">{{ $records->currentPage() + 1 }}</a>
                                    </li>
                                @endif

                                @if ($records->currentPage() < $records->lastPage() - 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $records->currentPage() + 2 }})">{{ $records->currentPage() + 2 }}</a>
                                    </li>
                                @endif

                                @if ($records->hasMorePages())
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
    function goBack() {
        window.history.back(); // Go back to the previous page
    }
</script>
{{-- Modal --}}
<div wire.ignore.self class="modal fade" id="orderRecordModal" tabindex="-1" aria-labelledby="orderRecordModal"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-top modal-lg">
        <livewire:food-order.order-record-modal />
    </div>
</div>


@section('custom_script')
    @include('layouts.scripts.food-order-scripts')
@endsection
