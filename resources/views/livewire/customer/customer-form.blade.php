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
            <div class="row justify-content-center align-items-center mb-4">
                <div class="col-md-3 text-center"> <!-- Adjusted column width -->
                    @if ($photo)
                        <img id="showImage" class="rounded-circle" width="80" height="80" src="{{ asset('storage/images/' . $photo) }}" alt="profile">
                    @else
                        <span>No photo available</span>
                    @endif
                </div>
            
                <div class="col-md-9"> <!-- Adjusted column width -->
                    <div class="input-block local-top-form">
                        <label class="local-top">Avatar <span class="login-danger">*</span></label>
                        <div class="settings-btn upload-files-avator">
                            <input type="file" wire:model="photo" id="image" class="hide-input">
                            <label for="image" class="upload">Choose File</label>
                        </div>
                        @error('photo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
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
                        <label> Contact No.<span class="login-danger">*</span></label>
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

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('photoPreview', function (photoUrl) {
            $('#showImage').attr('src', photoUrl);
        });

        $('#image').on('change', function (e) {
            var reader = new FileReader();
            reader.onload = function (e) {
                Livewire.emit('updatePhotoPreview', e.target.result);
            };
            reader.readAsDataURL(e.target.files[0]);
        });
    });
</script>
@endpush

