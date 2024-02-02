<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            @if ($packageId)
                Edit Package
            @else
                Add Package
            @endif
        </h1>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <form wire:submit.prevent="store" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label>Name <span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="name" placeholder />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label>Price <span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="price" placeholder />
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label>Limitation of Main Dish <span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="limitation_of_maindish" placeholder />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label>Minimum Pax <span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="minimum_pax" placeholder />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group local-forms">
                        <label>Description <span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="description" placeholder />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
