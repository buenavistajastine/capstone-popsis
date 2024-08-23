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
                                        <h3>Customer Details</h3>
                                        <div class="doctor-search-blk">
                                            <div class="add-group">
                                                <a class="btn btn-primary ms-2" wire:click="createCustomer">
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
                                        <th></th>
                                        <th>Name</th>
                                        <th>Contact No.</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($customers->isEmpty())
                                        <tr>
                                            <td colspan="12" class="text-center">No data available in table.</td>
                                        </tr>
                                    @else
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td class="align-items-center">
                                                    @if ($customer->photo)
                                                        <img src="{{ asset('storage/images/' . $customer->photo) }}"
                                                            alt="Customer Photo" class="rounded-circle align-items-center" max-width="80"
                                                            height="50">
                                                    @else
                                                        <img src="{{ asset('assets/img/user.jpg') }}" alt="User Photo"  class="rounded-circle" width="50"
                                                        height="50">
                                                    @endif
    
                                                </td>
                                                <td>
                                                    {{ ucfirst($customer->last_name) }},
                                                    {{ ucfirst($customer->first_name) }}
                                                    {{ $customer->middle_name ? ucfirst($customer->middle_name) : '' }}
                                                </td>

                                                <td>
                                                    @if ($customer->contact_no)
                                                    {{ $customer->contact_no }}
                                                    @else
                                                    <small><i>No contact</i></small>
                                                    @endif
                                                </td>
                                                {{-- @php
                                                    dd($customer);
                                                @endphp --}}
                                                <td>
                                                    @if ($customer->address)
                                                        {{ ucfirst($customer->address->city ?? '') }},
                                                        {{ ucfirst($customer->address->barangay ?? '') }}
                                                    @else
                                                        <i><small>No address available</small></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="custom-badge status-green">{{ $customer->status->name }}</button>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-primary btn-sm mx-1"
                                                            wire:click="editCustomer({{ $customer->id }})"
                                                            title="Edit">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                        @hasrole(['admin', 'manager'])
                                                            @if (is_null($customer->user_id))
                                                                <button type="button" class="btn btn-primary btn-sm mx-1"
                                                                    wire:click="createCustomerAccount({{ $customer->id }})"
                                                                    title="Create Account">
                                                                    Register <i class="fa-solid fa-user-plus"></i>
                                                                </button>
                                                            @else
                                                            @endif
                                                        @endhasrole
                                                        {{-- @else
                                                            <button type="button"
                                                                class="btn btn-inverse-warning btn-sm mx-1"
                                                                wire:click="editCustomerAccount({{ $customer->user_id }})"
                                                                title="Edit Account">
                                                                Edit Account <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>
                                                        @endif --}}
                                                        @hasrole('admin')
                                                            {{-- <a class="btn btn-danger btn-sm mx-1"
                                                                wire:click="deleteCustomer({{ $customer->id }})"
                                                                title="Delete">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </a> --}}
                                                        @endhasrole
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
                                    Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of
                                    {{ $customers->total() }}
                                    entries
                                </div>

                                <ul class="pagination pagination-separated mb-0 justify-content-center">
                                    @if ($customers->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" wire:click="previousPage"
                                                wire:loading.attr="disabled">Previous</a></li>
                                    @endif

                                    @if ($customers->currentPage() > 2)
                                        <li class="page-item"><a class="page-link"
                                                wire:click="gotoPage({{ $customers->currentPage() - 2 }})">{{ $customers->currentPage() - 2 }}</a>
                                        </li>
                                    @endif

                                    @if ($customers->currentPage() > 1)
                                        <li class="page-item"><a class="page-link"
                                                wire:click="gotoPage({{ $customers->currentPage() - 1 }})">{{ $customers->currentPage() - 1 }}</a>
                                        </li>
                                    @endif

                                    <li class="page-item active"><span
                                            class="page-link">{{ $customers->currentPage() }}</span>
                                    </li>

                                    @if ($customers->hasMorePages())
                                        <li class="page-item"><a class="page-link"
                                                wire:click="gotoPage({{ $customers->currentPage() + 1 }})">{{ $customers->currentPage() + 1 }}</a>
                                        </li>
                                    @endif

                                    @if ($customers->currentPage() < $customers->lastPage() - 1)
                                        <li class="page-item"><a class="page-link"
                                                wire:click="gotoPage({{ $customers->currentPage() + 2 }})">{{ $customers->currentPage() + 2 }}</a>
                                        </li>
                                    @endif

                                    @if ($customers->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" wire:click="nextPage"
                                                wire:loading.attr="disabled">Next</a>
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
    <div wire.ignore.self class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModal"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <livewire:customer.customer-form />
        </div>
    </div>

    <div wire.ignore.self class="modal fade" id="customerAccountModal" tabindex="-1"
        aria-labelledby="customerAccountModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <livewire:customer.register-account-form />
        </div>
    </div>



    @section('custom_script')
        @include('layouts.scripts.customer-scripts')
    @endsection
