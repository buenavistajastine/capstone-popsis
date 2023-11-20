<div>
	@if ($message = session()->has('success'))
		<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
			<div class="text-dark">{{ session('success') }}</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	@if ($message = session()->has('error'))
		<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
			<div class="text-dark">{{ session('error') }}</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	@if ($message = session()->has('warning'))
		<div id="alert" class="alert alert-warning alert-dismissible fade show" role="alert">
			<div class="text-dark">{{ session('warning') }}</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	@if ($message = session()->has('info'))
		<div id="alert" class="alert alert-primary alert-dismissible fade show" role="alert">
			<div class="text-dark">{{ session('info') }}</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	@if ($errors->any())
		<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
			<div class="text-dark">
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif
</div>
