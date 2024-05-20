<div class="content">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item">All Bookings</li>
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
                                    <h3>Booking List</h3>
                                    <div class="doctor-search-blk">
                                        <div class="add-group">
                                            <a class="btn btn-primary ms-2" wire:click="createBooking">
                                                <img alt src="{{ asset('assets/img/icons/plus.svg') }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="booking_records" class="ps-4"
                                    style="position: relative; top: -10px;"><small><i>Records</i></small></a>
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
                                    <th>Event</th>
                                    <th>Venue</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($bookings->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No data available in table.</td>
                                    </tr>
                                @else
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12 mb-1 text-justify fw-bold">
                                                        {{ ucwords($booking->customers->last_name) }},
                                                        {{ ucwords($booking->customers->first_name) }}
                                                        {{ $booking->customers->middle_name ? ucfirst($booking->customers->middle_name) : '' }}
                                                    </div>
                                                    <div class="col-12">
                                                        <small>#{{ $booking->booking_no }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12 mb-1 text-justify">
                                                        {{ $booking->event_name }} - <i>{{ $booking->no_pax }} Pax</i>
                                                    </div>
                                                    <div class="col-md-12 mb-1">
                                                        {{ $booking['date_event'] ? \Carbon\Carbon::parse($booking['date_event'])->format('F j, Y') : '' }}
                                                        at
                                                        <strong>{{ $booking['call_time'] ? \Carbon\Carbon::parse($booking['call_time'])->format('g:i A') : '' }}</strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($booking->address->venue_address || $booking->address->barangay || $booking->address->city)
                                                    <div class="row">
                                                        <div class="col-md-12 mb-1 text-justify">
                                                            {{ $booking->address->venue_address ? ucfirst($booking->address->venue_address) : '' }}
                                                        </div>
                                                        <div class="col-md-12 mb-1">
                                                            <small>
                                                                {{ $booking->address->barangay ? ucfirst($booking->address->barangay) . ', ' : '' }}
                                                                {{ $booking->address->city ? ucfirst($booking->address->city) : '' }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                @endif
                                                {{-- @if ($booking->address->specific_address || $booking->address->landmark)
                                                    <div>
                                                        {{ $booking->address->specific_address ? ucfirst($booking->address->specific_address) . ' ' : '' }}
                                                        ({{ $booking->address->landmark ? $booking->address->landmark : '' }})
                                                    </div>
                                                @endif --}}
                                            </td>
                                            @if ($booking->status_id == 3)
                                                <td colspan="5" class="text-center">
                                                    <button class="custom-badge status-pink">
                                                        {{ $booking->status->name }}</button>
                                                </td>
                                            @else
                                                <td>
                                                    @if ($booking->status_id == 1)
                                                        <button
                                                            class="custom-badge status-orange">{{ $booking->status->name }}</button>
                                                    @elseif ($booking->status_id == 2)
                                                        <button
                                                            class="custom-badge status-green">{{ $booking->status->name }}</button>
                                                    @elseif ($booking->status_id == 3)
                                                        <button class="custom-badge status-pink">
                                                            {{ $booking->status->name }}</button>
                                                    @elseif ($booking->status_id == 11)
                                                        <button class="custom-badge status-blue">
                                                            {{ $booking->status->name }}</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button type="button" class="btn btn-primary btn-sm mx-1"
                                                            wire:click="editBooking({{ $booking->id }})"
                                                            title="Edit">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>

                                                        @if ($booking->status_id == 1)
                                                            <button type="button" class="btn btn-success btn-sm mx-1"
                                                                onclick="confirmAction('accept', {{ $booking->id }})"
                                                                title="Accept Booking">
                                                                <i class="fa-solid fa-check-to-slot"></i>
                                                            </button>
                                                        @elseif($booking->status_id !== 1)
                                                            <a class="btn btn-primary btn-sm mx-1"
                                                                href="{{ route('module_print', $booking->id) }}"
                                                                target="_blank" title="View Booking">
                                                                <i class="fa-solid fa-print"></i>
                                                            </a>
                                                        @endif
                                                        <button type="button" class="btn btn-danger btn-sm mx-1"
                                                            onclick="confirmAction('cancel', {{ $booking->id }})"
                                                            title="Cancel Booking">
                                                            <i class="fa-solid fa-calendar-xmark"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <tfoot>
                        <div class="d-md-flex align-items-center m-2 p-2">
                            <div class="me-md-auto counterHead text-sm-left text-center mb-2 mb-md-0">
                                Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of
                                {{ $bookings->total() }} entries
                            </div>
                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($bookings->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage"
                                            wire:loading.attr="disabled">Previous</a></li>
                                @endif

                                @if ($bookings->currentPage() > 2)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $bookings->currentPage() - 2 }})">{{ $bookings->currentPage() - 2 }}</a>
                                    </li>
                                @endif

                                @if ($bookings->currentPage() > 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $bookings->currentPage() - 1 }})">{{ $bookings->currentPage() - 1 }}</a>
                                    </li>
                                @endif

                                <li class="page-item active"><span
                                        class="page-link">{{ $bookings->currentPage() }}</span></li>

                                @if ($bookings->hasMorePages())
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $bookings->currentPage() + 1 }})">{{ $bookings->currentPage() + 1 }}</a>
                                    </li>
                                @endif

                                @if ($bookings->currentPage() < $bookings->lastPage() - 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $bookings->currentPage() + 2 }})">{{ $bookings->currentPage() + 2 }}</a>
                                    </li>
                                @endif

                                @if ($bookings->hasMorePages())
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
<div wire.ignore.self class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModal"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-top modal-lg">
        <livewire:booking.booking-form />
    </div>
</div>

@push('scripts')
    <script>
        function confirmAction(action, bookingId) {
            const messages = {
                accept: 'Are you sure you want to ACCEPT this booking?',
                cancel: 'Are you sure you want to CANCEL this booking?'
            };
            if (confirm(messages[action])) {
                const eventMap = {
                    accept: 'acceptBooking',
                    cancel: 'cancelBooking'
                };
                Livewire.emit(eventMap[action], bookingId);
            }
        }
    </script>
@endpush

@section('custom_script')
    @include('layouts.scripts.booking-scripts')
@endsection
