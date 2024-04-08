<div class="content">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item">Kitchen Dish List</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($bookings as $booking)
            <div class="col-12 col-md-6 col-xl-3 d-flex">
                <div class="card report-blk">
                    <div class="card-body">
                        <div class="report-head card-header">
                            <h4 class="me-2 text-center mb-3 fw-bold">Call Time: {{ $booking['call_time'] ? \Carbon\Carbon::parse($booking['call_time'])->format('g:i A') : '' }}</h4>
                            <h4 class="card-title mb-0 fs-6">{{ ucfirst(optional($booking->customers)->last_name) }}, {{ ucfirst(optional($booking->customers)->first_name) }}</h4>
                            <div class="ps-4">
                                <p style="color: #333548; font-size: 12px; font-weight: 600;">Loc: {{ ucfirst(optional($booking->address)->barangay) }}, {{ ucfirst(optional($booking->address)->city) }}</p>
                            </div>
                        </div>
                        <div class="dash-content">
                            @foreach ($booking->dish_keys as $dishKey)
                                <div class="form-check">
                                    @can('edit-kitchen')
                                    <input wire:change="updateStatus({{ $dishKey->id }})" class="form-check-input checkbox-class" type="checkbox" value="{{ $dishKey->dishes->id }}" id="dish_{{ $dishKey->dishes->id }}" {{ $dishKey->status_id == 6 ? 'checked' : '' }}>
                                    <label class="form-check-label custom_check" for="dish_{{ $dishKey->dishes->id }}">
                                        <p style="color: #333548; font-size: 12px; font-weight: 600;">{{ $dishKey->dishes->name }}</p>
                                    </label>
                                    @elsecannot('edit-kitchen')
                                    <p style="color: #333548; font-size: 12px; font-weight: 600;">{{ $dishKey->dishes->name }}</p>
                                    @endcan
                                  
                                </div>
                            @endforeach
                            @foreach ($booking->addOns as $addOn)
                                <div class="form-check">
                                    @can('edit-kitchen')
                                    <input wire:change="updateAddOns({{ $addOn->id }})" class="form-check-input checkbox-class" type="checkbox" value="{{ $addOn->dishss->id }}" id="addon_{{ $addOn->dishss->id }}" {{ $addOn->status_id == 6 ? 'checked' : '' }}>
                                    <label class="form-check-label custom_check" for="addon_{{ $addOn->dishss->id }}">
                                        <p style="color: #333548; font-size: 12px; font-weight: 600;">{{ $addOn->dishss->name }}</p>
                                    </label>
                                    @elsecannot('edit-kitchen')
                                        <p style="color: #333548; font-size: 12px; font-weight: 600;">{{ $addOn->dishss->name }}</p>
                                    @endcan
                                
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
