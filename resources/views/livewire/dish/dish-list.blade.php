{{-- <div class="content">
    <div class="d-flex align-items-center mb-3 card-header">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                <li class="breadcrumb-item active">Dish</li>
            </ul>
        </div>

    </div>

    <div class="card mx-auto border-0">

        <div class="card-body p-3">
                <div>
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="doctor-table-blk">
                                <h3>Dish List</h3>
                                <div class="doctor-search-blk">
                                    <div class="add-group">
                                        <a class="btn btn-primary ms-2" wire:click="createDish">
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
                
                <div class="row mt-3">
                    <div class="col-md-1 fw-bold">
                        <h5>Filter by:</h5>
                    </div>
                    <div class="col-md-2">
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
                </div>
                

                <div class="table-responsive mb-3">
                    <table class="table mb-0 border-0 custom-table tabe-hover">
                        <thead>
                            <tr>
                             
                                <th style="width: 20%">Menu</th>
                                <th style="width: 30%">Dish</th>
                                <th style="width: 20%">Price(Full Chafing)</th>
                                <th style="width: 20%">Price(Half Chafing)</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($dishes->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">No data available in table.</td>
                            </tr>
                      
                            @else
                            @foreach ($dishes as $dish)
                                <tr>
                                   
                                    <td>{{ $dish->menu->name }}</td>
                                    <td>{{ $dish->name }}</td>
                                    <td class="text-center">₱ {{ number_format($dish->price_full, 2) }}</td>
                                    <td class="text-center">₱ {{ number_format($dish->price_half, 2) }}</td>
                                    <td>

                                        <div class="btn-group btn-group-xs" role="group">
                                            <button type="button" class="btn btn-primary btn-sm mx-1"
                                                wire:click="editDish({{ $dish->id }})" title="Edit">
                                                 <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <a class="btn btn-danger btn-sm mx-1"
                                                wire:click="deleteDish({{ $dish->id }})" title="Delete">
                                                 <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="d-md-flex align-items-center">
                    <div class="me-md-auto text-md-left text-center mb-2 mb-md-0">
                        Showing {{ $dishes->firstItem() }} to {{ $dishes->lastItem() }} of {{ $dishes->total() }}
                        entries
                    </div>

                    <ul class="pagination pagination-separated mb-0 justify-content-center">
                        @if ($dishes->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">Previous</span></li>
                        @else
                            <li class="page-item"><a class="page-link" wire:click="previousPage"
                                    wire:loading.attr="disabled">Previous</a></li>
                        @endif

                        @if ($dishes->currentPage() > 2)
                            <li class="page-item"><a class="page-link"
                                    wire:click="gotoPage({{ $dishes->currentPage() - 2 }})">{{ $dishes->currentPage() - 2 }}</a>
                            </li>
                        @endif

                        @if ($dishes->currentPage() > 1)
                            <li class="page-item"><a class="page-link"
                                    wire:click="gotoPage({{ $dishes->currentPage() - 1 }})">{{ $dishes->currentPage() - 1 }}</a>
                            </li>
                        @endif

                        <li class="page-item active"><span class="page-link">{{ $dishes->currentPage() }}</span>
                        </li>

                        @if ($dishes->hasMorePages())
                            <li class="page-item"><a class="page-link"
                                    wire:click="gotoPage({{ $dishes->currentPage() + 1 }})">{{ $dishes->currentPage() + 1 }}</a>
                            </li>
                        @endif

                        @if ($dishes->currentPage() < $dishes->lastPage() - 1)
                            <li class="page-item"><a class="page-link"
                                    wire:click="gotoPage({{ $dishes->currentPage() + 2 }})">{{ $dishes->currentPage() + 2 }}</a>
                            </li>
                        @endif

                        @if ($dishes->hasMorePages())
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
        </div>
    </div>
</div> --}}

<div class="content">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="/">Dashboard</a></li>
					<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
					<li class="breadcrumb-item">Dish List</li>
				</ul>
			</div>
		</div>
	</div>
	<livewire:flash-message.flash-message />
	<div class="row d-flex justify-content-center">
		<div class="col-sm-12">
			<div class="card card-table show-entire">
				<div class="card-body">
					<div class="page-table-header mb-2">
						<div class="row align-items-center">
							<div class="col">
                                <div class="doctor-table-blk">
                                    <h3>Dish List</h3>
                                    <div class="doctor-search-blk">
                                        <div class="add-group">
                                            <a class="btn btn-primary ms-2" wire:click="createDish">
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

                    <div class="row mt-3">
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
                    </div>

					<div class="table-responsive">
						<table class="table border-0 custom-table comman-table table-hover mb-0">
							<thead>
                                <tr>
                                    
                                    <th style="width: 3%"></th>
                                    <th style="width: 17%">Menu</th>
                                    <th style="width: 30%">Dish</th>
                                    <th style="width: 20%">Price(Full Chafing)</th>
                                    <th style="width: 20%">Price(Half Chafing)</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
							<tbody>
                                @if ($dishes->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">No data available in table.</td>
                                </tr>
                          
                                @else
                                @foreach ($dishes as $dish)
                                    <tr>
                                       <td></td>
                                        <td>{{ $dish->menu->name }}</td>
                                        <td>{{ $dish->name }}</td>
                                        <td class="text-center">₱ {{ number_format($dish->price_full, 2) }}</td>
                                        <td class="text-center">₱ {{ number_format($dish->price_half, 2) }}</td>
                                        <td>
    
                                            <div class="btn-group btn-group-xs" role="group">
                                                <button type="button" class="btn btn-primary btn-sm mx-1"
                                                    wire:click="editDish({{ $dish->id }})" title="Edit">
                                                     <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <a class="btn btn-danger btn-sm mx-1"
                                                    wire:click="deleteDish({{ $dish->id }})" title="Delete">
                                                     <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
						</table>
					</div>
                    <tfoot>
                        <div class="d-md-flex align-items-center m-2 p-2">
                            <div class="me-md-auto counterHead text-sm-left text-center mb-2 mb-md-0">
                                Showing {{ $dishes->firstItem() }} to {{ $dishes->lastItem() }} of {{ $dishes->total() }}
                                entries
                            </div>
        
                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($dishes->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage"
                                            wire:loading.attr="disabled">Previous</a></li>
                                @endif
        
                                @if ($dishes->currentPage() > 2)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $dishes->currentPage() - 2 }})">{{ $dishes->currentPage() - 2 }}</a>
                                    </li>
                                @endif
        
                                @if ($dishes->currentPage() > 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $dishes->currentPage() - 1 }})">{{ $dishes->currentPage() - 1 }}</a>
                                    </li>
                                @endif
        
                                <li class="page-item active"><span class="page-link">{{ $dishes->currentPage() }}</span>
                                </li>
        
                                @if ($dishes->hasMorePages())
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $dishes->currentPage() + 1 }})">{{ $dishes->currentPage() + 1 }}</a>
                                    </li>
                                @endif
        
                                @if ($dishes->currentPage() < $dishes->lastPage() - 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $dishes->currentPage() + 2 }})">{{ $dishes->currentPage() + 2 }}</a>
                                    </li>
                                @endif
        
                                @if ($dishes->hasMorePages())
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
                   
				</div>
			</div>
		</div>
	</div>
</div>

<div wire.ignore.self class="modal fade" id="dishModal" tabindex="-1" aria-labelledby="dishModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <livewire:dish.dish-form />
    </div>
</div>

</div>
@section('custom_script')
    @include('layouts.scripts.dish-scripts')
@endsection
