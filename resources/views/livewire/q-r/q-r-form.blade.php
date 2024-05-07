<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <form wire:submit.prevent="store" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center align-items-center mb-4">
                        <div class="col-md-12 text-center mb-4"> <!-- Adjusted column width -->
                            @if ($qr_code)
                                <img id="showImage" width="75%" height="75%" src="{{ asset('upload/images/' . $qr_code) }}" alt="profile">
                            @else
                                <span>No photo available</span>
                            @endif
                        </div>
                    
                        <div class="col-md-12"> <!-- Adjusted column width -->
                            <div class="input-block local-top-form">
                                <label class="local-top">QR Code <span class="login-danger">*</span></label>
                                <div class="settings-btn upload-files-avator">
                                    <input type="file" wire:model="qr_code" id="image" class="hide-input">
                                    <label for="image" class="upload">Choose File</label>
                                </div>
                                @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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