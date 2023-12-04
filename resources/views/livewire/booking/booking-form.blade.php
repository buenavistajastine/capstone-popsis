<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            @if ($bookingId)
                Edit Booking
            @else
                Add Booking
            @endif
        </h1>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <form wire:submit.prevent="store" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                {{-- Customer Details --}}


                <div class="col-6">
                    <h4 class=" mb-3">Customer Details</h4>
                    <div class="row">

                        <div class="col-md-8 mb-3">
                            <div class="form-group local-forms">
                                <label>Existing Customer?
                                </label>
                                <select class="form-control select" wire:model="customer_id"
                                    wire:change="loadCustomerDetails">
                                    <option selected value="">--select--</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->last_name }},
                                            {{ $customer->first_name }} {{ $customer->last_name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            {{-- <div class="form-group local-forms">
                                    <label>Contact</label>
                                    <input class="form-control" type="text" wire:model="contact_no" placeholder />
                                </div> --}}
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-group local-forms">
                                <label>First Name</label>
                                <input class="form-control" type="text" wire:model="first_name" placeholder
                                    @if ($customer_id) readonly @endif />
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label>Middle Name</label>
                                <input class="form-control" type="text" wire:model="middle_name" placeholder
                                    @if ($customer_id) readonly @endif />
                                @error('middle_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label>Last Name</label>
                                <input class="form-control" type="text" wire:model="last_name" placeholder
                                    @if ($customer_id) readonly @endif />
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-group local-forms">
                                <label>No. of Pax</label>
                                <input class="form-control" type="text" wire:model="no_pax" placeholder />
                                @error('no_pax')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group local-forms">
                                <label>Event Venue (Address)</label>
                                <input class="form-control" type="text" wire:model="venue_address" placeholder />
                                @error('venue_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label>Contact No.</label>
                                <input class="form-control" type="text" wire:model="contact_no" placeholder />
                                @error('contact_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Date of Event
                            </label>
                            <div class="input-group flatpickr" id="flatpickr-date">
                                <input type="text" class="form-control flatpickr-input" placeholder=""
                                    wire:model="date_event" data-input>
                                <span class="input-group-text input-group-addon" data-toggle><i
                                        class="fa-regular fa-calendar"></i></span>
                                @error('date_event')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label>Date of Event
                            </label>
                            <div class="input-group flatpickr" id="flatpickr-time">
                                <input type="text" class="form-control flatpickr-input" placeholder=""
                                    wire:model="call_time" data-input>
                                <span class="input-group-text input-group-addon" data-toggle><i
                                        class="fa-regular fa-clock"></i></span>
                                @error('call_time')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label>Package</label>
                                <select wire:model="package_id" class="form-control select">
                                    <option selected value="">--select--</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->name }}</option>
                                    @endforeach
                                </select>
                                @error('package_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                {{-- <div class="d-flex justify-content-left align-items-center mb-3">
                    <h1 class="fs-5">Add Services</h1>
                    <div class="doctor-search-blk">
                        <div class="add-group">
                            <a wire:click.prevent="addDish" class="btn btn-primary ms-2">
                                Add
                            </a>
                        </div>
                    </div>
                </div>
                @foreach ($dishItems as $dishIndex => $dishItem)
                    <div class="row align-items-center">
                        <div class="d-flex ">
                            <div class="col-md-11">
                                <div class="form-group local-forms">
                                    <label>Dish
                                        <span class="login-danger">*</span>
                                    </label>
                                    <select wire:model="dishItems.{{ $dishIndex }}.dish_id"
                                        wire:change="calculateTotalPrice" id="dish_id_{{ $dishIndex }}"
                                        name="dishItems[{{ $dishIndex }}][dish_id]" class="form-control select">
                                        <option selected value="">--select--</option>
                                        @foreach ($dishes as $dish)
                                            <option value="{{ $dish->id }}">{{ $dish->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 pt-1 mx-1">
                                <button type="button" title="Delete Item" class="btn btn-danger btn-sm mx-1"
                                    wire:click="deleteDish({{ $dishIndex }})">
                                    <i class="fa fa-trash" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                @endforeach --}}
                <div class="row align-items-center">
                    @foreach ($menus as $menu)
                        <div class="d-flex justify-content-left align-items-center mb-3">
                            <h1 class="fs-5">Add Dishes for {{ $menu->name }}</h1>
                            <div class="doctor-search-blk">
                                <div class="add-group">
                                    <a wire:click.prevent="addDish('{{ $menu->id }}')" class="btn btn-primary ms-2">
                                        Add
                                    </a>
                                </div>
                            </div>
                        </div>
                        @foreach ($dishItems[$menu->id] as $dishIndex => $dishItem)
                            <div class="row align-items-center">
                                <div class="d-flex">
                                    <div class="col-md-11">
                                        <div class="form-group local-forms">
                                            <label>Dish
                                                <span class="login-danger">*</span>
                                            </label>
                                            <select wire:model="dishItems.{{ $menu->id }}.{{ $dishIndex }}.dish_id"
                                                wire:change="calculateTotalPrice" id="dish_id_{{ $menu->id }}_{{ $dishIndex }}"
                                                name="dishItems[{{ $menu->id }}][{{ $dishIndex }}][dish_id]"
                                                class="form-control select">
                                                <option selected value="">--select--</option>
                                                @foreach ($selectedDishes[$menu->id] as $dish)
                                                    <option value="{{ $dish->id }}">{{ $dish->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1 pt-1 mx-1">
                                        <button type="button" title="Delete Item" class="btn btn-danger btn-sm mx-1"
                                            wire:click="deleteDish('{{ $menu->id }}', {{ $dishIndex }})">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                
                
            </div>

        </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Save</button>
</div>
</form>
</div>
