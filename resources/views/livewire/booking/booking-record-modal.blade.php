<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            Booking Information
        </h1>
    </div>
    <div class="modal-body fs-small">
        @if ($booking)
            <div class="row">
                <div class="col-md-12 mb-2">
                    <span>Name: <strong>{{ $booking->customers->first_name }},
                            {{ $booking->customers->last_name }}</strong></span>
                </div>
                <div class="col-md-12 mb-2">
                    <span>Address: {{ $booking->address->city }}, {{ $booking->address->barangay }}
                        @if (!empty($booking->venues))
                        <small>({{ $booking->venues->name ?: '' }})</small></span>
                        @endif
                </div>
                <div class="col-md-12 mb-2">
                    <span>Event: {{ $booking->event_name }}</span>
                </div>
                <div class="col-md-12 mb-2">
                    <span>
                        Date & Time:
                        {{ $booking['date_event'] ? \Carbon\Carbon::parse($booking['date_event'])->format('F j, Y') : '' }}
                        at
                        {{ $booking['call_time'] ? \Carbon\Carbon::parse($booking['call_time'])->format('g:i A') : '' }}
                    </span>
                </div>
                <div class="col-md-12 mb-2">
                    <span>No. of Guests: {{ $booking->no_pax }} Pax</span>
                </div>
                <div class="col-md-12 mb-2">
                    <span>Package: {{ $booking->packages->name }}
                        <small>(₱{{ number_format($booking->packages->price, 2) }})</small></span>
                </div>
                <div class="col-md-12 mb-2">
                    <span>Total Amount: ₱{{ number_format($booking->total_price, 2) }} / {{ $booking->billing->first()->statuses->name }}</span>
                </div>                
                <div class="col-md-6 mb-2">
                    <div>Dishes: </div>
                    <div class="mb-1 ps-4">
                        @foreach ($booking->dish_keys as $dishKey)
                            <div>{{ $dishKey->dishes->name }}</div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div>Add-ons: </div>
                    <div class="mb-1 ps-4">
                        @foreach ($booking->addOns as $addOn)
                            <div>{{ optional($addOn->dishss)->name }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <p>No booking details found.</p>
                </div>
            </div>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
