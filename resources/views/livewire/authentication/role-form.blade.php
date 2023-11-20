<div class="modal-content">
	<div class="modal-header">
		<h1 class="modal-title fs-5">
			@if ($roleId)
				Edit Role
			@else
				Add Role
			@endif
		</h1>
		<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>

	<form wire:submit.prevent="store" enctype="multipart/form-data">
		<div class="modal-body">
			<div class="row">
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group local-forms">
								<label>Name
									</label>
								<input class="form-control" type="text" wire:model="name" placeholder />
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<h5 class="mb-2">Set Permissions</h5>
					@if (empty($selectedPerms))
						@foreach ($perms as $perm)
							<div class="form-check mb-2">
								<input type="checkbox" wire:model="permissions" class="form-check-input" value="{{ $perm->id }}"
									id="{{ $perm->id }}">
								<label class="form-check-label" for="{{ $perm->id }}">{{ $perm->name }}</label>
								@if ($errors->has('name'))
									<p style="color:red">{{ $errors->first('name') }}</p>
								@endif
							</div>
						@endforeach
					@else
						@foreach ($perms as $key => $value)
							<div class="form-check mb-2">
								<input class="form-check-input" wire:model="selectedPerms" value="{{ $value->id }}" type="checkbox"
									id="{{ $value->name }}" {{ in_array($value->id, $selectedPerms) ? 'checked' : '' }}>
								<label class="form-check-label" for="{{ $value->name }}">{{ $value->name }}</label>
							</div>
						@endforeach
					@endif
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Save</button>
		</div>
	</form>
</div>
