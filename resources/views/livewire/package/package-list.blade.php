<div class="content">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="/">Dashboard</a></li>
					<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
					<li class="breadcrumb-item">All Packages</li>
				</ul>
			</div>
		</div>
	</div>
	<livewire:flash-message.flash-message />
	<div class="row d-flex justify-content-center">
		<div class="col-sm-8">
			<div class="card card-table show-entire">
				<div class="card-body">
					<div class="page-table-header mb-2">
						<div class="row align-items-center">
							<div class="col">
                                <div class="doctor-table-blk">
                                    <h3>Package List</h3>
                                    <div class="doctor-search-blk">
                                        <div class="add-group">
                                            <a class="btn btn-primary ms-2" wire:click="createPackage">
                                                <img alt src="{{ asset('assets/img/icons/plus.svg') }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="col-auto text-end float-end ms-auto download-grp">
								<div class="top-nav-search table-search-blk">
									<form>
										<input class="form-control" name="search" placeholder="Search here" type="text"
											wire:model.debounce.500ms="search">
										<a class="btn"><img alt src="{{ asset('assets/img/icons/search-normal.svg') }}"></a>
									</form>
								</div>
							</div>
						</div>
					</div>

                    {{-- <div class="row mt-3">
                        <div class="col-md-1 ms-3 fw-bold">
                            <h5>Filter by:</h5>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group local-forms">
                                <label for="paymentMode">Menu</label>
                                <select class="form-control" wire:model="selectedMenuFilter" id="paymentMode">
                                    <option selected value="">All menus</option>
                                    @foreach ($menus as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> --}}

					<div class="table-responsive">
						<table class="table border-0 custom-table comman-table table-hover mb-0">
							<thead>
                                <tr>
                                    <th style="width: 5%"></th>
                                    <th style="width: 25%">Name</th>
                                    <th style="width: 10%">Price</th>
                                    <th style="width: 40%">Description</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
							<tbody>
                                @if ($packages->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">No data available in table.</td>
                                </tr>
                          
                                @else
                                <tr>
                                    <td colspan="5" class="text-center fw-bold">Within Metro Dumaguete (Valencia, Sibulan, Bacong, and Dumaguete)</td>
                                </tr>
                                @foreach ($packages as $package)

                                    @if ($package->venue_id == 1)
                                    <tr>
                                        <td></td>
                                        <td>{{ $package->name }}</td>
                                        <td  class="text-end">₱ {{ number_format($package->price, 2)}}</td>
                                        <td>{{ $package->description }}</td>
                                        <td>
    
                                            <div class="btn-group btn-group-xs" role="group">
                                                <button type="button" class="btn btn-primary btn-sm mx-1"
                                                    wire:click="editPackage({{ $package->id }})" title="Edit">
                                                     <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <a class="btn btn-danger btn-sm mx-1"
                                                    wire:click="deletePackage({{ $package->id }})" title="Delete">
                                                     <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-center fw-bold">Outside Metro Dumaguete</td>
                                </tr>
                                @foreach ($packages as $package)

                                    @if ($package->venue_id == 2)
                                    <tr>
                                        <td></td>
                                        <td>{{ $package->name }}</td>
                                        <td  class="text-end">₱ {{ number_format($package->price, 2)}}</td>
                                        <td>{{ $package->description }}</td>
                                        <td>
    
                                            <div class="btn-group btn-group-xs" role="group">
                                                <button type="button" class="btn btn-primary btn-sm mx-1"
                                                    wire:click="editPackage({{ $package->id }})" title="Edit">
                                                     <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <a class="btn btn-danger btn-sm mx-1"
                                                    wire:click="deletePackage({{ $package->id }})" title="Delete">
                                                     <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                @endif
                            </tbody>
						</table>
					</div>
                    {{-- <tfoot>
                        <div class="d-md-flex align-items-center m-2 p-2">
                            <div class="me-md-auto counterHead text-sm-left text-center mb-2 mb-md-0">
                                Showing {{ $packages->firstItem() }} to {{ $packages->lastItem() }} of {{ $packages->total() }}
                                entries
                            </div>
        
                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($packages->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage"
                                            wire:loading.attr="disabled">Previous</a></li>
                                @endif
        
                                @if ($packages->currentPage() > 2)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $packages->currentPage() - 2 }})">{{ $packages->currentPage() - 2 }}</a>
                                    </li>
                                @endif
        
                                @if ($packages->currentPage() > 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $packages->currentPage() - 1 }})">{{ $packages->currentPage() - 1 }}</a>
                                    </li>
                                @endif
        
                                <li class="page-item active"><span class="page-link">{{ $packages->currentPage() }}</span>
                                </li>
        
                                @if ($packages->hasMorePages())
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $packages->currentPage() + 1 }})">{{ $packages->currentPage() + 1 }}</a>
                                    </li>
                                @endif
        
                                @if ($packages->currentPage() < $packages->lastPage() - 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $packages->currentPage() + 2 }})">{{ $packages->currentPage() + 2 }}</a>
                                    </li>
                                @endif
        
                                @if ($packages->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" wire:click="nextPage" wire:loading.attr="disabled">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </tfoot>
                    --}}
				</div>
			</div>
		</div>
	</div>
</div>

<div wire.ignore.self class="modal fade" id="packageModal" tabindex="-1" aria-labelledby="packageModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <livewire:package.package-form />
    </div>
</div>

</div>
@section('custom_script')
    @include('layouts.scripts.package-scripts')
@endsection
