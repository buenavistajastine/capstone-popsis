

<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            @if ($customerId)
                Edit User
            @else
                Add User
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
                        <div class="col-md-4 mb-3">
                            <div class="form-group local-forms">
                                <label>
                                    First Name

                                </label>
                                <input class="form-control" type="text" wire:model="first_name" placeholder />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label>Middle Name</label>
                                <input class="form-control" type="text" wire:model="middle_name" placeholder />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group local-forms">
                                <label>
                                    Last Name

                                </label>
                                <input class="form-control" type="text" wire:model="last_name" placeholder />
                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <div class="form-group local-forms">
                                <label>
                                    Username

                                </label>
                                <input class="form-control" type="text" wire:model="username" placeholder />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group local-forms">
                                <label>
                                    Email

                                </label>
                                <input class="form-control" type="email" wire:model="email" placeholder />
                            </div>
                        </div>

                        @if ($customerId)
                            <div class="col-md-6">
                                <div class="form-group local-forms">
                                    <label>New Password</label>
                                    <input class="form-control" type="password" wire:model="password" placeholder />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group local-forms">
                                    <label>Confirm New Password</label>
                                    <input class="form-control" type="password" wire:model="password_confirmation"
                                        placeholder />
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group local-forms">
                                    <label>Password</label>
                                    <input class="form-control" type="password" wire:model="password" placeholder />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group local-forms">
                                    <label>Confirm Password</label>
                                    <input class="form-control" type="password" wire:model="password_confirmation"
                                        placeholder />
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Save</button>
</div>
</form>
</div>
