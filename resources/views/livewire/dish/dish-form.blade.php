<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5">
            @if ($dishId)
                Edit Dish Details
            @else
                Add Dish
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
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label class="form-label">Name<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="name" placeholder />
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="form-group local-forms">
                        <label class="form-label">Menu<span class="login-danger">*</span>
                        </label>
                        <select class="form-control select form-select-md" wire:model="menu_id">
                            <option selected value="">--select--</option>
                            @foreach ($menus as $menu)
                            <option value="{{ $menu->id }}">
                                {{ $menu->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label class="form-label">Price(Full Chafing)<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="price_full" placeholder />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group local-forms">
                        <label class="form-label">Price(Half Chafing)<span class="login-danger">*</span></label>
                        <input class="form-control" type="text" wire:model="price_half" placeholder />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group local-forms">
                        <label class="form-label">Description (optional)<span class="login-danger">*</span></label>
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
