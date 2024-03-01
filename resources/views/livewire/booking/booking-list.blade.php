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
                                    <a href="booking_records" class="ps-4" style="position: relative; top: -10px;"><small><i>Records</i></small></a>
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
                                        <th style="width: 20%;">Customer</th>
                                        <th style="width: 20%;">Event</th>
                                        <th style="width: 30%;">Venue</th>
                                        <th style="width: 20%;">Action</th>

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
                                                        <div class="col-md-12 mb-1 text-justify">
                                                            {{ ucwords($booking->customers->last_name) }},
                                                            {{ ucwords($booking->customers->first_name) }}
                                                            {{ $booking->customers->middle_name ? ucfirst($booking->customers->middle_name) : '' }}
                                                        </div>
                                                        <div class="col-12"><small>#<i>{{ $booking->booking_no }}</i></small></div>
                                                        {{-- <div class="col-md-12 mb-1 text-sm">
                                                            #{{ $booking->booking_no }}
                                                        </div> --}}
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
                                                    @if ($booking->venue_address || $booking->barangay || $booking->city)
                                                    <div>
                                                        {{ $booking->venue_address ? ucfirst($booking->venue_address) . ', ' : ''}}
                                                        {{ $booking->barangay ? ucfirst($booking->barangay) . ', ' : ''}}
                                                        {{ $booking->city ? ucfirst($booking->city) : ''}}
                                                    </div>
                                                    @endif
                                                
                                                    @if ($booking->specific_address || $booking->landmark)
                                                    <div>
                                                        {{ $booking->specific_address ? ucfirst($booking->specific_address) . ' ' : ''}}
                                                        ({{ $booking->landmark ? ($booking->landmark) : '' }})
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm mx-1"
                                                            wire:click="editBooking({{ $booking->id }})"
                                                            title="Edit"> <i
                                                                class="fa-solid fa-pen-to-square"></i></button>

                                                        {{-- <a href="{{ route('module_print', $booking->id) }} target="_blank">Module</a> --}}
                                                        <a class="btn btn-primary btn-sm mx-1" href="{{ route('module_print', $booking->id) }}"
                                                            target="_blank" title="View Booking">
                                                            <i class="fa-solid fa-print"></i>
                                                        </a>

                                                        <a class="btn btn-danger btn-sm mx-1"
                                                            wire:click="deleteBooking({{ $booking->id }})"
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
                                    Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of
                                    {{ $bookings->total() }}
                                    entries
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
                                            class="page-link">{{ $bookings->currentPage() }}</span>
                                    </li>

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


    @section('custom_script')
        @include('layouts.scripts.booking-scripts')
    @endsection
