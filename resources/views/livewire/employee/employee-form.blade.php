<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            @if ($employeeId)
                Edit Employee Details
            @else
                Add Employee
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
                <div class="col-md-4 mb-3">
                    <div class="form-group local-forms">
                        <label> First Name<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="first_name" placeholder />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label> Middle Name<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="middle_name" placeholder />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group local-forms">
                        <label> Last Name<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="last_name" placeholder />
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group local-forms">
                        <label>Sex<span class="login-danger">*</span>
                        </label>
                        <select class="form-control select" wire:model="gender">
                            <option selected value="">--select--</option>
                            @foreach ($genders as $gender)
                                <option value="{{ $gender->id }}">
                                    {{ $gender->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Birthdate<span class="login-danger">*</span>
                    </label>
                    <div class="input-group flatpickr" id="flatpickr-date">
                        <input type="text" class="form-control flatpickr-input" placeholder="yy/mm/dd"
                            wire:model="birthdate" data-input>
                        <span class="input-group-text input-group-addon" data-toggle><i
                                class="fa-regular fa-calendar"></i></span>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group local-forms">
                        <label> Contact No.<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="contact_no" placeholder />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label> Address<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="address" placeholder />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label>Civil Status<span class="login-danger">*</span>
                        </label>
                        <select class="form-control select" wire:model="civil_status_id">
                            <option selected value="">--select--</option>
                            @foreach ($civil_statuses as $civil_status)
                                <option value="{{ $civil_status->id }}">
                                    {{ $civil_status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label>Position<span class="login-danger">*</span>
                        </label>
                        <select class="form-control select" wire:model="position_id">
                            <option selected value="">--select--</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}">
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>


