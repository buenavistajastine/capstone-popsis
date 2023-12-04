<div class="page-content">
    <div class="d-flex align-items-center mb-3 card-header">
        <div>
            <ul class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Dish</li>
            </ul>
        </div>

    </div>

    <div class="card mx-auto border-0">

        <div class="card-body p-3">
            <div class="tab-pane fade show active" id="allTab">
                <div class=" mb-2 mt-2">
                    <h4 class="page-title fw-bold">DISH DETAILS</h4>
                    <div>
                        <a wire:click="createDish" type="button" class="btn btn-inverse-primary px-3 mb-2 mt-2">Add Dish <i class="fa-solid fa-plus"></i></a>

                    </div>
                </div>
                

                <div class="input-group mb-2">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false"><span class="d-none d-md-inline">Filter by menu</span><span
                            class="d-inline d-md-none"><i class="fa-solid fa-filter"></i></span> <b
                            class="caret"></b></button>
                    <div class="dropdown-menu">
                        <a wire:click="applyMenuFilter('')" class="dropdown-item" href="#">All Menus</a>
                        @foreach ($menus as $menu)
                            <a wire:click="applyMenuFilter('{{ $menu->id }}')" class="dropdown-item" href="#">
                                {{ $menu->name }}
                            </a>
                        @endforeach
                    </div>
                    <input wire:model.debounce.500ms="search" type="text" class="form-control bg-tertiary"
                        aria-label="Text input with dropdown button" placeholder="Search here...">
                        <div class="input-group-text bg-tertiary" id="btnGroupAddon"><i class="fa-solid fa-magnifying-glass"></i></div>

                </div>



                <div class="table-responsive mb-3">
                    <table class="table table-hover table-panel text-nowrap align-middle mb-0">
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
                                            <button type="button" class="btn btn-inverse-primary btn-sm mx-1"
                                                wire:click="editDish({{ $dish->id }})" title="Edit">
                                                Edit <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <a class="btn btn-inverse-danger btn-sm mx-1"
                                                wire:click="deleteDish({{ $dish->id }})" title="Delete">
                                                Delete <i class="fa-solid fa-trash"></i>
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
