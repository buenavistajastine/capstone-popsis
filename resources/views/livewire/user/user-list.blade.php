<div class="content">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item">All Customers</li>
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
                                    <h3>User Details</h3>
                                    <div class="doctor-search-blk">
                                        <div class="add-group">
                                            <a class="btn btn-primary ms-2" wire:click="createUser">
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
                                    <th style="width: 20%">Name</th>
                                    <th style="width: 20%">Role</th>
                                    <th style="width: 20%">Username</th>
                                    <th style="width: 25%">Email</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No data available in table.</td>
                                    </tr>
                                @else
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                {{-- @if ($user->photo)
                                                <img src="{{ asset('storage/images/' . $user->photo) }}" alt="User Photo" class="rounded-circle" width="50" height="50">

                                                @else
                                                    <span>No photo available</span>
                                                @endif --}}

                                            </td>
                                            <td class="text-capitalize">
                                                {{ $user->first_name }} {{ $user->middle_name ?? '' }}
                                                {{ $user->last_name }}
                                            </td>
                                            <td>
                                                @if ($user->roles->isNotEmpty())
                                                    @foreach ($user->roles as $role)
                                                        <button
                                                            class="custom-badge status-green fw-bold">{{ ucfirst($role->name) }}</button>
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                @else
                                                    No roles assigned
                                                @endif
                                            </td>

                                            <td>
                                                {{ $user->username }}
                                            </td>
                                            <td>
                                                {{ $user->email }}
                                            </td>
                                            @can('edit-users')
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-primary btn-sm mx-1"
                                                            wire:click="editUser({{ $user->id }})" title="Edit"> <i
                                                                class="fa-solid fa-pen-to-square"></i></button>

                                                    </div>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <tfoot>
                        <div class="d-md-flex align-items-center m-2 p-2">
                            <div class="me-md-auto counterHead text-sm-left text-center mb-2 mb-md-0">
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of
                                {{ $users->total() }}
                                entries
                            </div>

                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($users->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage"
                                            wire:loading.attr="disabled">Previous</a></li>
                                @endif

                                @if ($users->currentPage() > 2)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $users->currentPage() - 2 }})">{{ $users->currentPage() - 2 }}</a>
                                    </li>
                                @endif

                                @if ($users->currentPage() > 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $users->currentPage() - 1 }})">{{ $users->currentPage() - 1 }}</a>
                                    </li>
                                @endif

                                <li class="page-item active"><span class="page-link">{{ $users->currentPage() }}</span>
                                </li>

                                @if ($users->hasMorePages())
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $users->currentPage() + 1 }})">{{ $users->currentPage() + 1 }}</a>
                                    </li>
                                @endif

                                @if ($users->currentPage() < $users->lastPage() - 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $users->currentPage() + 2 }})">{{ $users->currentPage() + 2 }}</a>
                                    </li>
                                @endif

                                @if ($users->hasMorePages())
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
<div wire.ignore.self class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModal"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <livewire:user.user-form />
    </div>
</div>
@section('custom_script')
    @include('layouts.scripts.user-scripts')
@endsection
