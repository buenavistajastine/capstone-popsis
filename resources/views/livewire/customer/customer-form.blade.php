<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            @if ($customerId)
                Edit Customer Details
            @else
                Add Customer
            @endif
        </h1>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <form wire:submit.prevent="store" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group local-forms">
                        <label> First Name</label>
                        <input class="form-control" type="text" wire:model="first_name" placeholder />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label> Middle Name</label>
                        <input class="form-control" type="text" wire:model="middle_name" placeholder />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label> Last Name</label>
                        <input class="form-control" type="text" wire:model="last_name" placeholder />
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group local-forms">
                        <label>Sex
                        </label>
                        <select class="form-control select" wire:model="gender_id">
                            <option selected value="">--select--</option>
                            @foreach ($genders as $gender)
                                <option value="{{ $gender->id }}">
                                    {{ $gender->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group local-forms">
                        <label> Contact No.</label>
                        <input class="form-control" type="text" wire:model="contact_no" placeholder />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>


