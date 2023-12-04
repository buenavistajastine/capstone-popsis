<div>
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Customers</li>
            </ol>
        </nav>

        <div class="row d-flex justify-content-center">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="page-title fw-bold mb-2">CUSTOMER DETAILS</h4>

                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <button type="button" class="btn btn-md btn-inverse-primary px-3"
                                    wire:click="createCustomer">Add Customer <i class="fa-solid fa-plus"></i></button>
                            </div>
                            <div class="col-md-4"> <!-- Adjust the width here -->
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
                                        <th style="width: 20%;">Contact No.</th>
                                        <th style="width: 25%;">Address</th>
                                        <th style="width: 25%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($customers->isEmpty())
                                        <tr>
                                            <td colspan="12" class="text-center">No data available in table.</td>
                                        </tr>
                                    @else
                                        @foreach ($customers as $customer)
                                            {{-- @php
                                        $cust_addr = $customer->bookings;
                                    @endphp --}}
                                            <tr>
                                                <td>{{ $customer->last_name }}, {{ $customer->first_name }}
                                                    {{ $customer->middle_name }}</td>
                                                <td>{{ $customer->contact_no }}</td>
                                                <td>{{ $cust_addr->venue_address ?? '' }}</td>
                                                <td>

                                                    <div class="btn-group" role="group">
                                                        <button type="button"
                                                            class="btn btn-inverse-primary btn-sm mx-1"
                                                            wire:click="editCustomer({{ $customer->id }})"
                                                            title="Edit">
                                                            Edit <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                        {{-- @if (is_null($customer->user_id)) --}}
                                                            <button type="button"
                                                            @if (is_null($customer->user_id))
                                                                class="btn btn-inverse-primary btn-sm mx-1" @else class="btn btn-inverse-success btn-sm mx-1" @endif
                                                                wire:click="createCustomerAccount({{ $customer->id }})"
                                                                title="Create Account" @if (is_null($customer->user_id))  @else disabled @endif>
                                                                @if (is_null($customer->user_id)) Create Account  <i class="fa-solid fa-pen-to-square"></i>@else Registered <i class="fa-regular fa-circle-check"></i>@endif 
                                                            </button>
                                                        {{-- @else
                                                            <button type="button"
                                                                class="btn btn-inverse-warning btn-sm mx-1"
                                                                wire:click="editCustomerAccount({{ $customer->user_id }})"
                                                                title="Edit Account">
                                                                Edit Account <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>
                                                        @endif --}}
                                                        <a class="btn btn-inverse-danger btn-sm mx-1"
                                                            wire:click="deleteCustomer({{ $customer->id }})"
                                                            title="Delete">
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
                                Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of
                                {{ $customers->total() }} entries
                            </div>

                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($customers->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage"
                                            wire:loading.attr="disabled">Previous</a></li>
                                @endif

                                @foreach ($customers->getUrlRange(1, $customers->lastPage()) as $page => $url)
                                    @if ($page == $customers->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item"><a class="page-link"
                                                wire:click="gotoPage({{ $page }})">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                @if ($customers->hasMorePages())
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
    <div wire.ignore.self class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModal"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <livewire:customer.customer-form />
        </div>
    </div>

    <div wire.ignore.self class="modal fade" id="customerAccountModal" tabindex="-1"
        aria-labelledby="customerAccountModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <livewire:customer.customer-account-form />
        </div>
    </div>

</div>


@section('custom_script')
    @include('layouts.scripts.customer-scripts')
@endsection
