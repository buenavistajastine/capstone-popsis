<div class="content">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item">All Customers Account</li>
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
                                    <h3>Customer Account Details</h3>
                                    <div class="doctor-search-blk">
                                        {{-- <div class="add-group">
                                                <a class="btn btn-primary ms-2" wire:click="createCustomer">
                                                    <img alt src="{{ asset('assets/img/icons/plus.svg') }}">
                                                </a>
                                            </div> --}}
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
                                    <th style="width: 3%;"></th>
                                    <th style="width: 30%;">Name</th>
                                    <th style="width: 20%;">Username</th>
                                    <th style="width: 25%;">Email</th>
                                    <th style="width: 25%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($customerAccounts->isEmpty())
                                    <tr>
                                        <td colspan="12" class="text-center">No data available in table.</td>
                                    </tr>
                                @else
                                    @foreach ($customerAccounts as $cust_acc)
                                        {{-- @php
                                        $cust_addr = $customer->bookings;
                                    @endphp --}}
                                        <tr>
                                            @if (!is_null($cust_acc->users))
                                            <td></td>
                                            <td>{{ $cust_acc->users->last_name }}, {{ $cust_acc->users->first_name }}
                                                {{ $cust_acc->users->middle_name }}</td>
                                            
                                            <td>{{ $cust_acc->users->username }}</td>
                                            <td>{{ $cust_acc->users->email ?? '' }}</td>
                                            
                                            <td>

                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-primary btn-sm mx-1"
                                                        wire:click="editCustomerAccount({{ $cust_acc->users->id }})"
                                                        title="Edit">
                                                         <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>

                                                    {{-- <a class="btn btn-inverse-danger btn-sm mx-1"
                                                            wire:click="deleteCustomerAccount({{ $cust_acc->users->id }})"
                                                            title="Delete">
                                                            Delete <i class="fa-solid fa-trash"></i>
                                                        </a> --}}
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <tfoot>
                        <div class="d-md-flex align-items-center m-2 p-2">
                            <div class="me-md-auto counterHead text-sm-left text-center mb-2 mb-md-0">
                                Showing {{ $customerAccounts->firstItem() }} to {{ $customerAccounts->lastItem() }}
                                of
                                {{ $customerAccounts->total() }}
                                entries
                            </div>

                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($customerAccounts->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage"
                                            wire:loading.attr="disabled">Previous</a></li>
                                @endif

                                @if ($customerAccounts->currentPage() > 2)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $customerAccounts->currentPage() - 2 }})">{{ $customerAccounts->currentPage() - 2 }}</a>
                                    </li>
                                @endif

                                @if ($customerAccounts->currentPage() > 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $customerAccounts->currentPage() - 1 }})">{{ $customerAccounts->currentPage() - 1 }}</a>
                                    </li>
                                @endif

                                <li class="page-item active"><span
                                        class="page-link">{{ $customerAccounts->currentPage() }}</span>
                                </li>

                                @if ($customerAccounts->hasMorePages())
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $customerAccounts->currentPage() + 1 }})">{{ $customerAccounts->currentPage() + 1 }}</a>
                                    </li>
                                @endif

                                @if ($customerAccounts->currentPage() < $customerAccounts->lastPage() - 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $customerAccounts->currentPage() + 2 }})">{{ $customerAccounts->currentPage() + 2 }}</a>
                                    </li>
                                @endif

                                @if ($customerAccounts->hasMorePages())
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
<div wire.ignore.self class="modal fade" id="customerAccountEditModal" tabindex="-1"
    aria-labelledby="customerAccountEditModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <livewire:customer-account.customer-account-edit-form />
    </div>
</div>
{{-- 
    <div wire.ignore.self class="modal fade" id="customerAccountModal" tabindex="-1"
        aria-labelledby="customerAccountModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <livewire:customer.customer-account-form />
        </div>
    </div>

</div>
--}}

@section('custom_script')
    @include('layouts.scripts.customer-account-scripts')
@endsection
