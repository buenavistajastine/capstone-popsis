<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            @if ($bookingId)
                Edit Booking Details
            @else
                Add Booking
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
                <div class="col-md-4">
                    <div class="col-md-12 text-end download-grp">
                    <div class="col-md-12 top-nav-search2 table-search-blk mb-3">
                    <form>
                        <input class="form-control" name="search" placeholder="Search here" type="text"
                            wire:model.debounce.500ms="search">
                    </form>
                    </div>
                    </div>
                    <hr>
                    </hr>
                    <h5>Select Dish:</h5>
                    <div class="row dishes-container justify-center">
                        @if ($dishes->isEmpty())
                            <span class="text-center mb-2"><small>No results found.</small></span>
                        @endif
                        @foreach ($dishes as $dish)
                        <div class="col-md-12 dish-card">

                            <div class="col-md-12 mb-0">
                                <div class="col-md-12 ">
                                    <small><strong>{{ $dish->name }}</strong></small>
                                </div>
                            </div>

                            <div class="row d-flex justify-between align-items-center">

                                <div class="col-md-5">
                                <div class="col-md-12">
                                    <small><i>{{ $dish->type->name }}</i></small>
                                </div>
                                <div class="col-md-12 font-monospace d-flex">
                                    <div class="col-md-6 fs-4">
                                        <h4> ₱{{ number_format($dish->price_full, 2) }}</h4>
                                    </div>
                                </div>
                                <div class="col-md-12 font-monospace">
                                    <div class="col-md-6 fs-4">
                                        <h5>₱{{ number_format($dish->price_half, 2) }}</h5>
                                    </div>
                                </div>
                                </div>

                                <div class="col-md-7 float-end">
                                    <div class="col-md-12">
                                        <div class="row justify-evenly">
                                            <div class="btn btn-group btn-sm" role="group">
                                                <button type="button" class="btn btn-primary btn-sm me-1"
                                                wire:click="addDish({{ $dish->id }})" title="Add"
                                                @if ($this->isDishSelected($dish->id)) disabled @endif>
                                                @if ($this->isDishSelected($dish->id))
                                                    Added
                                                @else
                                                    <small>Add</small>
                                                @endif
                                                </button>
                                                <button type="button" class="btn btn-outline-primary btn-sm ms-1"
                                                wire:click="addAddOn({{ $dish->id }})" title="Add-On"
                                                @if ($this->isAddOnSelected($dish->id)) disabled @endif>
                                                @if ($this->isAddOnSelected($dish->id))
                                                    Added
                                                @else
                                                    Add-On
                                                @endif
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>


                <div class="col-md-8">
                    <div class="row">
                        @if (!isset($bookingId) || !$bookingId)
                        <div class="col-md-12 position-relative">
                        <div class="form-group local-forms">
                            <label>Search for Existing Customer<span class="login-danger">*</span></label>
                            <div class="custom-dropdown" style="z-index: 2;">
                            <input type="text" wire:model.debounce.300ms="searchQuery"
                                class="form-control" placeholder="Search Customer">
                            <div class="dropdown-content" style="max-height: 200px; overflow-y: auto;"
                                @if (!$searchQuery || (isset($customers) && $customers->isEmpty())) style="display: none;" @endif>
                                @if ($searchQuery && (!isset($customers) || $customers->isNotEmpty()))
                                @foreach ($customers as $customer)
                                    <div wire:key="{{ $customer->id }}"
                                    wire:click="selectCustomer({{ $customer->id }})"
                                    class="dropdown-item cursor-pointer fs-8">
                                    {{ $customer->first_name }} {{ $customer->last_name }}
                                    </div>
                                @endforeach
                                @endif
                            </div>
                            </div>
                        </div>
                        </div>
                        @endif

                        <div class="col-md-4 mb-2">
                        <div class="form-group local-forms">
                            <label style="z-index: 1">First Name<span class="login-danger">*</span></label>
                            <input class="form-control" type="text" wire:model="first_name" placeholder />
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label style="z-index: 1">Last Name<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" wire:model="last_name" placeholder />
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label style="z-index: 1">Contact No.<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" wire:model="contact_no" placeholder />
                                @error('contact_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <h4 class="mb-3">Address</h4>
                        <div class="col-md-12">
                            <div class="form-group">
                                @foreach ($venues as $venue)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="venue_id"
                                            id="venue_{{ $venue->id }}" wire:change="updatePackages"
                                            wire:model="selectedVenue" value="{{ $venue->id }}">
                                        <label class="form-check-label" style="z-index: 1"
                                            for="venue_{{ $venue->id }}">
                                            {{ $venue->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label style="z-index: 1">City/Town<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" wire:model="city" placeholder />
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label style="z-index: 1">Barangay<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" wire:model="barangay" placeholder />
                                @error('barangay')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label style="z-index: 1">Event's Place/ Venue<span
                                        class="login-danger">*</span></label>
                                <input class="form-control" type="text" wire:model="venue_address" placeholder />
                                @error('venue_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group local-forms">
                                <label style="z-index: 1">Specific Address<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" wire:model="specific_address"
                                    placeholder />
                                @error('specific_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group local-forms">
                                <label>Landmark (optional)</label>
                                <input class="form-control" type="text" wire:model="landmark" placeholder />
                                @error('landmark')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <h4 class="mb-3">Booking Details</h4>

                        <div class="col-md-3">
                            <div class="form-group local-forms">
                                <label>Date of Event <span class="login-danger">*</span></label>
                                <input class="form-control" type="date" wire:model="date_event">
                                @error('date_event')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group local-forms">
                                <label>Call Time <span class="login-danger">*</span></label>
                                <input type="time" class="form-control" wire:model="call_time">
                                @error('call_time')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group local-forms">
                                <label>Event Name<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" wire:model="event_name" placeholder />
                                @error('event_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group local-forms">
                                <label>No. of Guests<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" wire:model="no_pax"
                                    wire:change="calculateTotalPrice" placeholder />
                                @error('no_pax')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group local-forms">
                                <label>Package<span class="login-danger">*</span></label>
                                <select wire:model="package_id" class="form-control select">
                                    <option selected value="">--select--</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->name }} (₱
                                            {{ $package->price }}
                                            /person)</option>
                                    @endforeach
                                </select>
                                @error('package_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group local-forms">
                                <label>Motif (color 1)<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" wire:model="color" placeholder />
                                @error('color')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group local-forms">
                                <label>Motif (color 2)<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" wire:model="color2" placeholder />
                                @error('color2')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label>Additional Payment</label>
                                <input class="form-control text-end" type="text" wire:model="additional_amt"
                                    wire:change="calculateTotalPrice" placeholder />

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label>Advance Payment</label>
                                <input class="form-control text-end" type="text" wire:model="advance_amt"
                                    wire:change="calculateTotalPrice" placeholder />

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label>Discount Amount</label>
                                <input class="form-control text-end" type="text" wire:model="discount_amt"
                                    wire:change="calculateTotalPrice" placeholder />

                            </div>
                        </div>
                        <div class="col-md-12">
                            <span style="font-size: small"><i>Note: {{ $this->packageDescription }}</i></span>
                        </div>


                        <h4 class="mb-3">Selected Dishes</h4>
                        @if (empty($selectedDishes))
                            <small class="text-center"><i>Please select dishes.</i></small>
                        @else
                            @foreach ($selectedDishes as $index => $selectedDish)
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-2">
                                        <button disabled class="custom-badge status-blue">
                                            {{ $selectedDish['type_id'] }}</button>

                                    </div>
                                    <div class="col-md-6"><small>{{ $selectedDish['name'] }}</small></div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control text-center"
                                            wire:model="selectedDishes.{{ $index }}.quantity"
                                            wire:change="updateDishQuantity({{ $index }}, $event.target.value)">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm"
                                            wire:click="removeDish({{ $index }})">Remove</button>
                                    </div>
                                </div>
                            @endforeach
                        @endif


                        <h4 class="mb-3 mt-3">Selected Add-Ons <i style="font-size: small;"
                                class="text-danger">(Prices
                                are not included in the
                                package.)</i></h4>
                        @if (empty($selectedAddOns))
                            <small class="text-center"><i>Please select add-ons.</i></small>
                        @else
                            @foreach ($selectedAddOns as $index => $selectedAddOn)
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-7"><small>{{ $selectedAddOn['name'] }}</small></div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control text-center"
                                            wire:model="selectedAddOns.{{ $index }}.quantity"
                                            wire:change="calculateTotalPrice">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm"
                                            wire:click="removeAddOn({{ $index }})">Remove</button>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div class="row mb-3 mt-3">
                            <h4 class="fs-6">Additional Request:</h4>
                            <div class="col-12 col-sm-12">
                                <div class="input-block local-forms">
                                    <textarea class="form-control" rows="3" cols="30" wire:model="remarks" placeholder="Write here..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4 mt-4 me-2">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-8">
                                    <div class="row  d-flex">
                                        <div class="col-md-6">
                                            <h4 class="font-monospace text-end">Sub-total:</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="font-monospace text-end fw-bold">
                                                {{ number_format($totalBookingPrice, 2) }}</h4>
                                        </div>
                                    </div>
                                    <div class="row  d-flex">
                                        <div class="col-md-6">
                                            <h4 class="font-monospace text-end">Add-ons:</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="font-monospace text-end fw-bold">
                                                {{ number_format($totalAddOnPrice, 2) }}</h4>
                                        </div>
                                    </div>

                                    <div class="row  d-flex">
                                        <div class="col-md-6">
                                            <h3 class="font-monospace text-end">Total Amount:</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <h3 class="font-monospace text-end fw-bold">{{ $total_price }}</h3>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @if ($can_rebook == true)
                        <div class="col-12">
                            <div class="doctor-submit text-end">
                                <button type="button" wire:click="reBook" class="btn btn-primary me-2">Rebook Service</button>
                            </div>
                        </div>
                        @else
                        <div class="col-12">
                            <div class="doctor-submit text-end">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </form>

</div>
