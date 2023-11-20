<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            @if ($userId)
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
                <div class="col-md-8">
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
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
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
                    </div>
                    @if (!isset($userId))
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group local-forms">
                                    <label>
                                        Password
                                       
                                    </label>
                                    <input class="form-control" type="password" wire:model="password" placeholder />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group local-forms">
                                    <label>
                                        Confirm Password
                                 
                                    </label>
                                    <input class="form-control" type="password" wire:model="password_confirmation"
                                        placeholder />
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($userId)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group local-forms">
                                        <label>New Password</label>
                                        <input class="form-control" type="password" wire:model="password" placeholder />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group local-forms">
                                        <label>Confirm New Password</label>
                                        <input class="form-control" type="password" wire:model="password_confirmation" placeholder />
                                    </div>
                                </div>
                            </div>
                        @endif


                   

                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <div class="table-responsive">
                                <table class="table border-0 custom-table comman-table mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%"></th>
                                            <th style="width: 70%">Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($selectedRoles))
                                        @foreach ($roles as $role)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model.defer="selectedRoles"
                                                    class="form-input" value="{{ $role->id }}" {{ in_array($role->id,
                                                $selectedRoles) ? 'checked' : '' }}>
							</td>
							<td>
								<span class="text-capitalize">{{ $role->name }}</span>
							</td>
							</tr>
							@endforeach
							@else

							@endif
							</tbody>
							</table>
						</div> --}}
                        <h6 class="mb-2">Assign Role:</h6>
                            <div style="height: 150px;">
                                @if (empty($selectedRoles))
                                    @forelse ($roles as $role)
                                        <div class="form-check mb-2">
                                            <input wire:model.defer="roleCheck" type="checkbox" class="form-check-input"
                                                value="{{ $role->name }}" id="{{ $role->name }}">
                                            <label class="form-check-label text-capitalize" for="{{ $role->name }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @empty
                                        <p>No roles found</p>
                                    @endforelse
                                @else
                                    @forelse ($roles as $role)
                                        <div class="form-check mb-2">
                                            <input wire:model.defer="selectedRoles" type="checkbox"
                                                class="form-check-input" value="{{ $role->name }}"
                                                id="{{ $role->name }}"
                                                {{ in_array($role->name, $selectedRoles) ? 'checked' : '' }}>
                                            <label class="form-check-label text-capitalize" for="{{ $role->name }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @empty
                                        <p>No roles found</p>
                                    @endforelse
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
				
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
