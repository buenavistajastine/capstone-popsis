<div class="content">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item">Booking Billing</li>
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
                                    <h3>Booking Billing List</h3>
                                    {{-- <div class="doctor-search-blk">
                                        <div class="add-group">
                                            <a class="btn btn-primary ms-2" wire:click="createDish">
                                                <img alt src="{{ asset('assets/img/icons/plus.svg') }}">
                                            </a>
                                        </div>
                                    </div> --}}
                                </div>
                                <a href="booking_billing_record" class="ps-3"
                                    style="position: relative; top: -5px;"><small><i>Records</i></small></a>
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

                    <div class="row mt-3">
                        {{-- <div class="col-md-1 ms-3 fw-bold">
                            <h5>Filter by:</h5>
                        </div> --}}
                        {{-- <div class="col-md-3">
                            <div class="form-group local-forms">
                                <label for="paymentMode">Menu</label>
                                <select class="form-control" wire:model="selectedMenuFilter" id="paymentMode">
                                    <option selected value="">All menus</option>
                                    @foreach ($menus as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                    </div>

                    <div class="table-responsive">
                        <table class="table border-0 custom-table comman-table table-hover mb-0">
                            <thead>
                                <tr>

                                    {{-- <th style="width: 3%"></th> --}}
                                    <th>Name</th>
                                    <th>Event Package </th>
                                    <th>Paid Amount</th>
                                    <th>Balance</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($billings->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No data available in table.</td>
                                    </tr>
                                @else
                                    @foreach ($billings as $billing)
                                        <tr>
                                            {{-- <td></td> --}}
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12 mb-1 text-justify fw-bold">
                                                        {{ ucwords($billing->customers->last_name) }},
                                                        {{ ucwords($billing->customers->first_name) }}
                                                        {{ $billing->customers->middle_name ? ucfirst($billing->customers->middle_name) : '' }}
                                                    </div>
                                                    <div class="col-12">
                                                        <small>#{{ $billing->bookings->booking_no }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($billing->bookings)
                                                    {{ optional($billing->bookings->packages)->name }} <span
                                                        style="font-size: small">(₱
                                                        {{ optional($billing->bookings->packages)->price }} /pax)</span>
                                                    <div class="col-12 fw-bold">
                                                        <small>{{ ucfirst($billing->bookings->event_name) }}
                                                        </small>
                                                    </div>
                                                @endif
                                                @if (optional($billing->bookings)->dishess && count($billing->bookings->dishess) > 0)
                                                    <div class="row">
                                                        <small>
                                                            <span class="text-success">Add-ons:</span>
                                                            <div class="row ps-3">
                                                                @foreach ($billing->bookings->dishess as $addon)
                                                                    {{-- @foreach ($addon as $dish) --}}
                                                                    <div class="ps-3 text-success">{{ $addon->name }}
                                                                    </div>
                                                                    {{-- @endforeach --}}
                                                                @endforeach
                                                            </div>
                                                        </small>
                                                    </div>
                                                @endif
                                                <div class="col-12 fw-bold">
                                                    <small>Total Amount:
                                                    </small>
                                                    ₱ {{ number_format($billing->total_amt, 2) }}
                                                </div>
                                            </td>

                                            <td class="text-center">₱ {{ number_format($billing->paid_amt, 2) }}</td>
                                            <td class="text-center">₱ {{ number_format($billing->payable_amt, 2) }}
                                            </td>
                                            <td class="text-center">
                                                @if (!empty($billing->payment_id))
                                                    {{ $billing->payments->name ?: '' }}
                                                @endif
                                            </td>

                                            <td>
                                                @if ($billing->status_id == 6)
                                                    <button
                                                        class="custom-badge status-orange">{{ $billing->statuses->name }}</button>
                                                @elseif ($billing->status_id == 5)
                                                    <button
                                                        class="custom-badge status-green">{{ $billing->statuses->name }}</button>
                                                @elseif ($billing->status_id == 13)
                                                    <button
                                                        class="custom-badge status-pink">{{ $billing->statuses->name }}</button>
                                                @endif
                                            </td>
                                            <td>

                                                <div class="btn-group btn-group-xs" role="group">
                                                    <button type="button" class="btn btn-primary btn-sm mx-1"
                                                        wire:click="editBilling({{ $billing->id }})" title="Edit">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <a class="btn btn-primary btn-sm mx-1"
                                                        href="{{ route('print.claim-slip', $billing->id) }}"
                                                        target="_blank" title="View Booking">
                                                        <i class="fa-solid fa-print"></i>
                                                    </a>
                                                    {{-- <a class="btn btn-danger btn-sm mx-1"
                                                        wire:click="deleteBilling({{ $billing->id }})" title="Delete">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a> --}}
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
                                Showing {{ $billings->firstItem() }} to {{ $billings->lastItem() }} of
                                {{ $billings->total() }}
                                entries
                            </div>

                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($billings->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage"
                                            wire:loading.attr="disabled">Previous</a></li>
                                @endif

                                @if ($billings->currentPage() > 2)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $billings->currentPage() - 2 }})">{{ $billings->currentPage() - 2 }}</a>
                                    </li>
                                @endif

                                @if ($billings->currentPage() > 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $billings->currentPage() - 1 }})">{{ $billings->currentPage() - 1 }}</a>
                                    </li>
                                @endif

                                <li class="page-item active"><span
                                        class="page-link">{{ $billings->currentPage() }}</span>
                                </li>

                                @if ($billings->hasMorePages())
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $billings->currentPage() + 1 }})">{{ $billings->currentPage() + 1 }}</a>
                                    </li>
                                @endif

                                @if ($billings->currentPage() < $billings->lastPage() - 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $billings->currentPage() + 2 }})">{{ $billings->currentPage() + 2 }}</a>
                                    </li>
                                @endif

                                @if ($billings->hasMorePages())
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

<div wire.ignore.self class="modal fade" id="billingModal" tabindex="-1" aria-labelledby="billingModal"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <livewire:billing.billing-form />
    </div>
</div>

</div>
@section('custom_script')
    @include('layouts.scripts.billing-scripts')
@endsection
