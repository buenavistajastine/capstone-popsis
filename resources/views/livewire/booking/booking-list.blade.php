<div>
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Bookings</li>
            </ol>
        </nav>

        <div class="row d-flex justify-content-center">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="page-title fw-bold mb-2">BOOKING DETAILS</h4>

                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <button type="button" class="btn btn-md btn-inverse-primary px-3"
                                    wire:click="createBooking">Add Booking <i class="fa-solid fa-plus"></i></button>
                            </div>
                            <div class="col-md-4"> <!-- Adjust the width here -->
                                <div class="input-group">

                                    <input wire:model.debounce.300ms="search" type="text"
                                        class="form-control bg-tertiary search-input"
                                        aria-label="Text input with dropdown button" placeholder="Search here...">
                                    <div class="input-group-text" id="btnGroupAddon"><i
                                            class="fa-solid fa-magnifying-glass"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mb-3">
                            <table class="table table-hover table-panel text-nowrap align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Customer</th>
                                        <th style="width: 30%;">Date of Event</th>
                                        <th style="width: 20%;">Pax</th>
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
                                                <td>{{ $booking->customers->last_name }},
                                                    {{ $booking->customers->first_name }}
                                                    {{ $booking->customers->middle_name }}</td>
                                                <td>{{ $booking['date_event'] ? Carbon::parse($booking['date_event'])->format('M j, Y') : '' }}
                                                    at
                                                    {{ $booking['call_time'] ? Carbon::parse($booking['call_time'])->format('g:i A') : '' }}
                                                </td>
                                                <td>{{ $booking->no_pax }} Pax</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button type="button"
                                                            class="btn btn-inverse-primary btn-sm mx-1"
                                                            wire:click="editBooking({{ $booking->id }})"
                                                            title="Edit">Edit <i
                                                                class="fa-solid fa-pen-to-square"></i></button>

                                                        <a class="btn btn-inverse-danger btn-sm mx-1"
                                                            wire:click="deleteBooking({{ $booking->id }})"
                                                            title="Delete">Delete <i class="fa-solid fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="d-md-flex align-items-center">
                            <div class="me-md-auto text-md-left text-center mb-2 mb-md-0">
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

                                @foreach ($bookings->getUrlRange(1, $bookings->lastPage()) as $page => $url)
                                    @if ($page == $bookings->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item"><a class="page-link"
                                                wire:click="gotoPage({{ $page }})">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                @if ($bookings->hasMorePages())
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


                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    <div wire.ignore.self class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModal"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-top modal-xl">
            <livewire:booking.booking-form />
        </div>
    </div>
</div>

@section('custom_script')
    @include('layouts.scripts.booking-scripts')
@endsection
