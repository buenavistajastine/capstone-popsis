
 <div>
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Users</li>
            </ol>
        </nav>

        <div class="row d-flex justify-content-center">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="page-title fw-bold mb-2">USER DETAILS</h4>

                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <button type="button" class="btn btn-md btn-inverse-primary px-3"
                                    wire:click="createUser">Add User <i
                                        class="fa-solid fa-plus"></i></button>
                            </div>
                            <div class="col-md-4"> <!-- Adjust the width here -->
                                <div class="input-group">
                                    
                                    <input wire:model.debounce.300ms="search" type="text"
                                        class="form-control bg-tertiary search-input"
                                        aria-label="Text input with dropdown button"
                                        placeholder="Search here...">
                                        <div class="input-group-text" id="btnGroupAddon"><i
                                            class="fa-solid fa-magnifying-glass"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mb-3">
                            <table class="table table-hover table-panel text-nowrap align-middle mb-0">
                                <thead>
                                    <tr>
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
                                            <td class="text-capitalize">
                                                {{ $user->first_name }} {{ $user->middle_name ?? '' }}
                                                {{ $user->last_name }}
                                            </td>
                                            <td>
                                                @if ($user->roles->isNotEmpty())
                                                    @foreach ($user->roles as $role)
                                                        {{ $role->name}}
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
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-inverse-primary btn-sm mx-1"
                                                    wire:click="editUser({{ $user->id }})"
                                                        title="Edit">Edit <i
                                                            class="fa-solid fa-pen-to-square"></i></button>
    
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
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                            </div>
                        
                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($users->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage" wire:loading.attr="disabled">Previous</a></li>
                                @endif
                        
                                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                    @if ($page == $users->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                        
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

