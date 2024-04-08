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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <livewire:flash-message.flash-message />
    <form wire:submit.prevent="store" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">

                {{-- <div class="col-md-4 ">
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
                                </div> --}}
                <h4 class="mb-3">Customer Details</h4>
                {{-- <div class="col-md-4 mb-2">
                    <div class="form-group local-forms">
                        <label>Ordered by:<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="ordered_by" placeholder
                            @if ($customer_id) readonly @endif />
                        @error('ordered_by')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}
                {{-- @if ($customer_id) readonly @endif  --}}
                <div class="col-md-4 mb-2">
                    <div class="form-group local-forms">
                        <label>First Name<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="first_name" placeholder />
                        @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Last Name<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="last_name" placeholder />
                        @error('last_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Contact No.<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="contact_no" placeholder />
                        @error('contact_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- <div class="col-md-3">
                    <div class="form-group local-forms">
                        <label>Event Name<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="event_name" placeholder />
                        @error('event_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}
                <h4 class="mb-3">Address</h4>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>City/Town<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="city" placeholder />
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Barangay<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="barangay" placeholder />
                        @error('barangay')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Street No.<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="specific_address" placeholder />
                        @error('specific_address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Landmark<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="landmark" placeholder />
                        @error('landmark')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <h4 class="mb-3">Order Details</h4>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Transportation<span class="login-danger">*</span></label>
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

                {{-- <div class="col-md-3">
                    <div class="form-group local-forms">
                        <label>No. of Pax<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="no_pax" placeholder />
                        @error('no_pax')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}

                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Date<span class="login-danger">*</span></label>
                        <input class="form-control" type="date" wire:model="date_need">
                        @error('date_need')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label>Call Time <span class="login-danger">*</span></label>
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


                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="d-flex justify-content-left align-items-center">
                                    <h6 class="fs-5">Dishes</h6>
                                </div>
                                <table class="table border-0 custom-table comman-table mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 75%">Dish</th>
                                            <th style="width: 20%">Quantity</th>
                                            <th style="width: 5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dishItems as $dishIndex => $dishItem)
                                            <tr>
                                                <td>
                                                    <select wire:model="dishItems.{{ $dishIndex }}.dish_id"
                                                        wire:change="calculatePrice" id="dish_id_{{ $dishIndex }}"
                                                        name="dishItems[{{ $dishIndex }}][dish_id]"
                                                        class="form-control select">
                                                        <option selected value="">-- choose dish --</option>
                                                        @foreach ($dishes->groupBy('menu.name') as $menu => $menuDishes)
                                                            <optgroup label="{{ $menu }}">
                                                                @foreach ($menuDishes as $dish)
                                                                    <option value="{{ $dish->id }}">
                                                                        {{ $dish->name }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text"
                                                        name="dishItems[{{ $dishIndex }}][quantity]"
                                                        wire:model="dishItems.{{ $dishIndex }}.quantity"
                                                        wire:change="calculatePrice" placeholder />
                                                </td>
                                                <td>
                                                    <div class="col-md-1 pt-1 mx-1">
                                                        <button type="button" title="Delete Item"
                                                            wire:change="calculatePrice"
                                                            class="btn btn-danger btn-sm mx-1"
                                                            wire:click="deleteDish({{ $dishIndex }})">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 mt-3">
                                    <div>
                                        <button wire:click.prevent="addDish" class="btn btn-primary ms-2">
                                            <i class="fa fa-plus"></i> Add another dish
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label style="z-index: 1">Total Price
                            <span class="login-danger">*</span>
                        </label>
                        <input type="text" wire:model="total_price" class="form-control text-end" placeholder
                            readonly />
                    </div>
                </div> --}}
                <div class="col-md-12 mb-4">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="col-md-12 d-flex pe-2 justify-content-between">
                                <div>
                                    <h4>Total Price:</h4>
                                </div>
                                <div class="text-end">
                                    <h4>{{ $total_price }}</h4>
                                </div>
                            </div>

                            {{-- <div class="col-md-12 d-flex justify-content-between">
                                <div>
                                    <h5>Additional Payment:</h5>
                                </div>
                                <div class="text-end">
                                    <h4></h4>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                {{-- <div class="row mb-2">
                    <div class="col-6">
                        <div>
                            <div class="row align-items-center">
                                <div class="d-flex justify-content-left align-items-center mb-3">
                                    <h6 class="fs-5">Dishes</h6>
                                    <div class="doctor-search-blk">
                                        <div class="add-group">
                                            <a wire:click.prevent="addDish" class="btn btn-primary ms-2">
                                                <img alt src="{{ asset('assets/img/icons/plus.svg') }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($dishItems as $dishIndex => $dishItem)
                                    <div class="row align-items-center">
                                        <div class="d-flex justify-contents-center">
                                            <div class="col-md-8">
                                                <div class="form-group local-forms">
                                                    <select wire:model="dishItems.{{ $dishIndex }}.dish_id" wire:change="calculatePrice"
                                                        id="dish_id_{{ $dishIndex }}"
                                                        name="dishItems[{{ $dishIndex }}][dish_id]"
                                                        class="form-control select">
                                                        <option selected value="">-- choose dish --</option>
                                                        @foreach ($dishes->groupBy('menu.name') as $menu => $menuDishes)
                                                            <optgroup label="{{ $menu }}">
                                                                @foreach ($menuDishes as $dish)
                                                                    <option value="{{ $dish->id }}">
                                                                        {{ $dish->name }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" type="text"
                                                    name="dishItems[{{ $dishIndex }}][quantity]"
                                                    wire:model="dishItems.{{ $dishIndex }}.quantity" wire:change="calculatePrice" placeholder />
                                            </div>
                                            <div class="col-md-1 pt-1 mx-1">
                                                <button type="button" title="Delete Item"
                                                    class="btn btn-danger btn-sm mx-1"
                                                    wire:click="deleteDish({{ $dishIndex }})">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="col-12">
                    <div class="doctor-submit text-end">
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
