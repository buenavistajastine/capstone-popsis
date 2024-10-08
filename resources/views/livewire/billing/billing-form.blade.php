<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            @if ($billingId)
                Edit Billing Details
            @endif
        </h1>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form wire:submit.prevent="store" enctype="multipart/form-data">
        <div class="modal-body">
            @if ($errorMessage)
                <div class="alert alert-danger">
                    {{ $errorMessage }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group local-forms input-group">
                                <label class="form-label">Amount to Pay<span class="login-danger">*</span></label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₱</span>
                                </div>
                                <input class="form-control text-end" type="text" wire:model="paid_amt" placeholder="0" />
                                <span class="input-group-text">.00</span>
                                @error('paid_amt')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group local-forms">
                                <label class="form-label">Mode of Payment<span class="login-danger">*</span></label>
                                <select class="form-control form-select" wire:model="payment_id">
                                    <option selected value="">--select--</option>
                                    @foreach ($payments as $payment)
                                        <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                    @endforeach
                                </select>
                                @error('payment_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @if (!empty($paid_amounts))
                        <hr>
                        <div class="row">
                            <div class="row">
                                <div class="col-md-4 text-center fw-bold"><small>Date</small></div>
                                <div class="col-md-4 text-center fw-bold"><small>Amount Paid</small></div>
                                <div class="col-md-4 text-center fw-bold"><small>Balance</small></div>
                            </div>
                            @foreach ($paid_amounts as $paid_amount)
                                <div class="col-md-4 text-center">
                                    <small>{{ $paid_amount['created_at'] ? \Carbon\Carbon::parse($paid_amount['created_at'])->format('F j, Y') : '' }}</small>
                                </div>
                                <div class="col-md-4 text-end">
                                    <small>{{ number_format($paid_amount->paid_amt, 2) }}</small>
                                </div>
                                <div class="col-md-4 text-end">
                                    <small>{{ number_format($paid_amount->payable_amt, 2) }}</small>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="row mt-3 text-end">
                        <a href="{{ url('payments/' . $billingId) }}" target="_blank">
                            <small class="text-decoration-underline"><i>see proof of payments</i></small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            @if ($billingStatus === 5)
                <button type="button" class="btn btn-primary" disabled>Already Paid</button>
            @else
                <button type="submit" class="btn btn-primary">Submit</button>
            @endif
        </div>
        
    </form>
</div>
