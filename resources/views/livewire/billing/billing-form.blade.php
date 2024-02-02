<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            @if ($billingId)
                Edit Billing Details
            @endif
        </h1>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit.prevent="store" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group local-forms">
                                <label class="form-label">Amount to Pay<span class="login-danger">*</span></label>
                                <input class="form-control text-end" type="text" wire:model="paid_amt" placeholder="0.00" />
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="form-group local-forms">
                                <label class="form-label">Mode of Payment<span class="login-danger">*</span>
                                </label>
                                <select class="form-control form-select" wire:model="payment_id">
                                    <option selected value="">--select--</option>
                                    @foreach ($payments as $payment)
                                    <option value="{{ $payment->id }}">
                                        {{ $payment->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-6 ">
                            <div class="form-group local-forms">
                                <label class="form-label">Type<span class="login-danger">*</span>
                                </label>
                                <select class="form-control select form-select-md" wire:model="type_id">
                                    <option selected value="">--select--</option>
                                    @foreach ($types as $type)
                                    <option value="{{ $type->id }}">
                                        {{ $type->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                    </div>
                       
                </div>
    
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
