<div>
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Customers Account</li>
            </ol>
        </nav>

        <div class="row d-flex justify-content-center">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="page-title fw-bold mb-2">CUSTOMER ACCOUNT DETAILS</h4>

                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                {{-- <button type="button" class="btn btn-md btn-inverse-primary px-3"
                                    wire:click="createCustomer">Add Customer <i class="fa-solid fa-plus"></i></button> --}}
                            </div>
                            <div class="col-md-12"> <!-- Adjust the width here -->
                                <div class="input-group">

                                    <input wire:model.debounce.300ms="search" type="text"
                                        class="form-control bg-tertiary search-input"
                                        aria-label="Text input with dropdown button" placeholder="Search here...">
                                    <div class="input-group-text" id="btnGroupAddon"><i
                                            class="fa-solid fa-magnifying-glass"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mb-3">
                            <table class="table table-hover table-panel text-nowrap align-middle mb-0">
                                <thead>
                                    <tr>
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
                                                <td>{{ $cust_acc->last_name }}, {{ $cust_acc->first_name }}
                                                    {{ $cust_acc->middle_name }}</td>
                                                <td>{{ $cust_acc->users->username }}</td>
                                                <td>{{ $cust_acc->users->email ?? '' }}</td>
                                                <td>

                                                    <div class="btn-group" role="group">
                                                        <button type="button"
                                                            class="btn btn-inverse-primary btn-sm mx-1"
                                                            wire:click="editCustomerAccount({{ $cust_acc->users->id }})"
                                                            title="Edit">
                                                            Edit <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                      
                                                        {{-- <a class="btn btn-inverse-danger btn-sm mx-1"
                                                            wire:click="deleteCustomerAccount({{ $cust_acc->users->id }})"
                                                            title="Delete">
                                                            Delete <i class="fa-solid fa-trash"></i>
                                                        </a> --}}
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
                                Showing {{ $customerAccounts->firstItem() }} to {{ $customerAccounts->lastItem() }} of
                                {{ $customerAccounts->total() }} entries
                            </div>

                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($customerAccounts->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage"
                                            wire:loading.attr="disabled">Previous</a></li>
                                @endif

                                @foreach ($customerAccounts->getUrlRange(1, $customerAccounts->lastPage()) as $page => $url)
                                    @if ($page == $customerAccounts->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item"><a class="page-link"
                                                wire:click="gotoPage({{ $page }})">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

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


                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal --}}
   <div wire.ignore.self class="modal fade" id="customerAccountEditModal" tabindex="-1" aria-labelledby="customerAccountEditModal"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
