<div class="content">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item"><a href="booking">All Bookings</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item">Booking Records</li>
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
                                    <h3>Booking Records</h3>

                                </div>
                                <a onclick="goBack()" href="booking" style="position: relative;"><small><i class="fa-solid fa-arrow-left"></i> <i>Back</i></small></a>
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
                                    <th>Event</th>
                                    <th>Package</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th></th>



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
                                                    <div class="col-md-12 mb-1 text-justify">
                                                        {{ ucwords($record->customers->last_name) }},
                                                        {{ ucwords($record->customers->first_name) }}
                                                        {{ $record->customers->middle_name ? ucfirst($record->customers->middle_name) : '' }}
                                                    </div>
                                                    <div class="col-12"><small>#{{ $record->booking_no }}</small>
                                                    </div>
                                                    {{-- <div class="col-md-12 mb-1 text-sm">
                                                        #{{ $record->record_no }}
                                                    </div> --}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12 mb-1 text-justify">
                                                        {{ $record->event_name }} - <i>{{ $record->no_pax }} Pax</i>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        {{ $record['date_event'] ? \Carbon\Carbon::parse($record['date_event'])->format('F j, Y') : '' }}
                                                        at
                                                        <strong>{{ $record['call_time'] ? \Carbon\Carbon::parse($record['call_time'])->format('g:i A') : '' }}</strong>

                                                    </div>

                                                </div>

                                            </td>
                                            <td>{{ $record->packages->name }}</td>

                                            <td>
                                                    <button
                                                        class="custom-badge status-pink">{{ $record->status->name }}</button>
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm mx-1"
                                                    wire:click="bookingDetails({{ $record->id }})" title="View"> <i
                                                        class="fa-solid fa-list-check"></i> View details</button>
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
{{-- Modal --}}
<div wire.ignore.self class="modal fade" id="bookingRecordModal" tabindex="-1" aria-labelledby="bookingRecordModal"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-top modal-lg">
        <livewire:booking.booking-record-modal />
    </div>
</div>

<script>
    function goBack() {
        window.history.back(); // Go back to the previous page
    }
</script>
@section('custom_script')
    @include('layouts.scripts.booking-scripts')
@endsection
