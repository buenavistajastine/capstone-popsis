<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            Booking Information
        </h1>
    </div>
    <div class="modal-body fs-small">
        @if ($order)
            <div class="row">
                <div class="col-md-12 mb-2">
                    <span>Name: <strong>{{ $order->customers->first_name }},
                            {{ $order->customers->last_name }}</strong></span>
                </div>
                <div class="col-md-12 mb-2">
                    <span>Address: {{ $order->customers->address->city }}, {{ $order->customers->address->barangay }}</span>
                </div>
                <div class="col-md-12 mb-2">
                    <span>
                        Date & Time:
                        {{ $order['date_need'] ? \Carbon\Carbon::parse($order['date_need'])->format('F j, Y') : '' }}
                        at
                        {{ $order['call_time'] ? \Carbon\Carbon::parse($order['call_time'])->format('g:i A') : '' }}
                    </span>
                </div>
                <div class="col-md-12 mb-2">
                    <span>Total Amount: ₱{{ number_format($order->total_price, 2) }}
                    @if ($order->billing)
                    / {{ $order->billing->statuses->name }}
                    @endif
                </span>
                </div>
                <div class="col-md-6 mb-2">
                    <div>Dishes: </div>
                    <div class="mb-1 ps-4">
                        @foreach ($order->orderDish_keys as $dishKey)
                            <div>{{ $dishKey->dishes->name }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <p>No order details found.</p>
                </div>
            </div>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
