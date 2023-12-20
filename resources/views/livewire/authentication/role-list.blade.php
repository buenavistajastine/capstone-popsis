<div class="content">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item">All Roles</li>
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
                                    <h3>Role Details</h3>
                                    <div class="doctor-search-blk">
                                        <div class="add-group">
                                            <a class="btn btn-primary ms-2" wire:click="createRole">
                                                <img alt src="{{ asset('assets/img/icons/plus.svg') }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto text-end float-end ms-auto download-grp">
                                <div class="top-nav-search table-search-blk">
                                    <form>
                                        <input class="form-control" name="search" placeholder="Search here"
                                            type="text" wire:model.debounce.500ms="search">
                                        <a class="btn"><img alt
                                                src="{{ asset('assets/img/icons/search-normal.svg') }}"></a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table border-0 custom-table comman-table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 3%"></th>
                                    <th style="width: 20%">ID</th>
                                    <th style="width: 60%">Name</th>
                                    <th style="width: 20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($roles->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No data available in table.</td>
                                    </tr>
                              
                                    @else
                                @foreach ($roles as $role)
                                    <tr>
                                        <td></td>
                                        <td>{{ $role->id }}</td>
                                        <td>
                                            <span class="text-capitalize">
                                                {{ $role->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-primary btn-sm mx-1"
                                                    wire:click="editRole({{ $role->id }})" title="Edit">
                                                     <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <a class="btn btn-danger btn-sm mx-1"
                                                    wire:click="deleteRole({{ $role->id }})" title="Delete">
                                                     <i class="fa-solid fa-trash"></i></i>
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
                                Showing {{ $roles->firstItem() }} to {{ $roles->lastItem() }} of
                                {{ $roles->total() }}
                                entries
                            </div>

                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($roles->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage"
                                            wire:loading.attr="disabled">Previous</a></li>
                                @endif

                                @if ($roles->currentPage() > 2)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $roles->currentPage() - 2 }})">{{ $roles->currentPage() - 2 }}</a>
                                    </li>
                                @endif

                                @if ($roles->currentPage() > 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $roles->currentPage() - 1 }})">{{ $roles->currentPage() - 1 }}</a>
                                    </li>
                                @endif

                                <li class="page-item active"><span class="page-link">{{ $roles->currentPage() }}</span>
                                </li>

                                @if ($roles->hasMorePages())
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $roles->currentPage() + 1 }})">{{ $roles->currentPage() + 1 }}</a>
                                    </li>
                                @endif

                                @if ($roles->currentPage() < $roles->lastPage() - 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $roles->currentPage() + 2 }})">{{ $roles->currentPage() + 2 }}</a>
                                    </li>
                                @endif

                                @if ($roles->hasMorePages())
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
{{-- Modal --}}
<div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <livewire:authentication.role-form />
    </div>
</div>
@section('custom_script')
    @include('layouts.scripts.role-scripts')
@endsection
