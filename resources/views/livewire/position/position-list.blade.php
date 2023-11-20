
    <div>
        <div class="page-content">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Positions</li>
                </ol>
            </nav>
    
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="page-title fw-bold mb-2">POSITION DETAILS</h4>
    
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <button type="button" class="btn btn-md btn-inverse-primary px-3"
                                    wire:click="createPosition">Add Position <i
                                            class="fa-solid fa-plus"></i></button>
                                </div>
                                <div class="col-md-4"> <!-- Adjust the width here -->
                                    <div class="input-group">
                                        <div class="input-group-text" id="btnGroupAddon"><i
                                                class="fa-solid fa-magnifying-glass"></i></div>
                                        <input wire:model.debounce.300ms="search" type="text"
                                            class="form-control bg-tertiary search-input"
                                            aria-label="Text input with dropdown button"
                                            placeholder="Search here...">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mb-3">
                                <table class="table table-hover table-panel text-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                        <th>Positions</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($positions->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No data available in table.</td>
                                    </tr>
                              
                                    @else
                                        @foreach ($positions as $position)
                                            <tr>
                                                <td>{{ $position->id }}</td>
                                                <td>{{ $position->name }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-inverse-primary btn-sm mx-1"
                                                        wire:click="editPosition({{ $position->id }})"
                                                        title="Edit">Edit <i
                                                            class="fa-solid fa-pen-to-square"></i>
                                                        </button>

                                                        <a class="btn btn-inverse-danger btn-sm mx-1"
                                                        wire:click="deletePosition({{ $position->id }})"
                                                            title="Delete">Delete <i class="fa-solid fa-trash"></i>
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
                                    Showing {{ $positions->firstItem() }} to {{ $positions->lastItem() }} of {{ $positions->total() }} entries
                                </div>
                            
                                <ul class="pagination pagination-separated mb-0 justify-content-center">
                                    @if ($positions->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" wire:click="previousPage" wire:loading.attr="disabled">Previous</a></li>
                                    @endif
                            
                                    @foreach ($positions->getUrlRange(1, $positions->lastPage()) as $page => $url)
                                        @if ($page == $positions->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</a></li>
                                        @endif
                                    @endforeach
                            
                                    @if ($positions->hasMorePages())
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
        </div>
        {{-- Modal --}}
        <div class="modal fade" id="positionModal" tabindex="-1" aria-labelledby="positionModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <livewire:position.position-form/>
            </div>
        </div>
        
        </div>
        
        @section('custom_script')
            @include('layouts.scripts.position-scripts')
        @endsection
    