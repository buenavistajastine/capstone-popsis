<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            @if ($orderId)
                Edit Food Order Details
            @else
                Add Food Order
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
                                            <small><i>{{ $dish->menu->name }}</i></small>
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
                        @if (!isset($orderId) || !$orderId)
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
                                            {{--     
                                    @if ($searchQuery && (!isset($customers) || $customers->isEmpty()))
                                        <div class="dropdown-item">No customers found.</div>
                                    @endif --}}
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
                                <label style="z-index: 1">Street No.<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" wire:model="specific_address"
                                    placeholder />
                                @error('specific_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label style="z-index: 1">Landmark<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" wire:model="landmark" placeholder />
                                @error('landmark')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <h4 class="mb-3">Order Details</h4>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label style="z-index: 1">Transportation<span class="login-danger">*</span></label>
                                <select wire:model="transport_id" class="form-control ">
                                    <option selected value="">--select--</option>
                                    @foreach ($transports as $transpo)
                                        <option value="{{ $transpo->id }}">{{ $transpo->name }}</option>
                                    @endforeach
                                </select>
                                @error('transport_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label style="z-index: 1">Date<span class="login-danger">*</span></label>
                                <input class="form-control" type="date" wire:model="date_need">
                                @error('date_need')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label style="z-index: 1">Call Time <span class="login-danger">*</span></label>
                                <input type="time" class="form-control" wire:model="call_time">
                                @error('call_time')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group local-forms">
                                <label style="z-index: 1">Remarks
                                    <span class="login-danger">*</span>
                                </label>
                                <input type="text" wire:model="remarks" class="form-control" placeholder />
                            </div>
                        </div>

                        <h4 class="mb-3">Selected Dishes</h4>
                        @if (empty($selectedDishes))
                            <small class="text-center"><i>Please select dishes.</i></small>
                        @else
                            @foreach ($selectedDishes as $index => $selectedDish)
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-2">
                                        <button disabled class="custom-badge status-blue">
                                            {{ $selectedDish['menu_id'] }}</button>

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
                    </div>


                </div>


                <div class="col-md-12 mb-4 mt-4">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
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
                <div class="col-12">
                    <div class="doctor-submit text-end">
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
