<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            @if ($positionId)
                Edit Position
            @else
                Add Position
            @endif
        </h1>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <form wire:submit.prevent="store" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group local-forms">
                        <label>Name</label>
                        <input class="form-control" type="text" wire:model="name" placeholder />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
