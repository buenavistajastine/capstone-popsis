{{-- <div>
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Employees</li>
            </ol>
        </nav>

        <div class="row d-flex justify-content-center">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4>All Employees <a class="btn btn-primary btn-icon" wire:click="createEmployee">
                                <i data-feather="user-plus"></i>
                            </a>
                        </h4>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;">Name</th>
                                        <th style="width: 10%;">Gender</th>
                                        <th style="width: 10%;">Position</th>
                                        <th style="width: 10%;">Contact No.</th>
                                        <th style="width: 25%;">Address</th>
                                        <th style="width: 20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)

                                        <tr>
                                            <td>{{ $employee->first_name }} {{ $employee->middle_name }}
                                                {{ $employee->last_name }}</td>
                                            <td>{{ $employee->gender->name }}</td>
                                            <td>{{ $employee->position->name }}</td>
                                            <td>{{ $employee->contact_no }}</td>
                                            <td>{{ $employee->address }}</td>
                                            <td>

                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-primary btn-sm btn-icon mx-1"
                                                        wire:click="editEmployee({{ $employee->id }})" title="Edit">
                                                        <i data-feather="edit" class="icon-md"></i>
                                                    </button>
                                                    <a class="btn btn-danger btn-sm btn-icon mx-1"
                                                        wire:click="deleteEmployee({{ $employee->id }})" title="Delete">
                                                        <i data-feather="trash" class="icon-md"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <livewire:employee.employee-form />
        </div>
    </div>

</div>


@section('custom_script')
    @include('layouts.scripts.employee-scripts')
@endsection --}}


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
                        <h4 class="page-title fw-bold mb-2">EMPLOYEE DETAILS</h4>

                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <button type="button" class="btn btn-md btn-inverse-primary px-3"
                                    wire:click="createEmployee">Add Employee <i
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
                                        <th style="width: 25%;">Name</th>
                                        <th style="width: 10%;">Gender</th>
                                        <th style="width: 10%;">Position</th>
                                        <th style="width: 10%;">Contact No.</th>
                                        <th style="width: 25%;">Address</th>
                                        <th style="width: 20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($employees->isEmpty())
                                    <tr>
                                        <td colspan="12" class="text-center">No data available in table.</td>
                                    </tr>
                              
                                    @else
                                    @foreach ($employees as $employee)

                                        <tr>
                                            <td>{{ $employee->first_name }} {{ $employee->middle_name }}
                                                {{ $employee->last_name }}</td>
                                            <td>{{ $employee->gender->name }}</td>
                                            <td>{{ $employee->position->name }}</td>
                                            <td>{{ $employee->contact_no }}</td>
                                            <td>{{ $employee->address }}</td>
                                            <td>

                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-inverse-primary btn-sm mx-1"
                                                    wire:click="editEmployee({{ $employee->id }})" title="Edit">
                                                        Edit <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <a class="btn btn-inverse-danger btn-sm mx-1"
                                                    wire:click="deleteEmployee({{ $employee->id }})" title="Delete">
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
                                Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} entries
                            </div>
                        
                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($employees->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage" wire:loading.attr="disabled">Previous</a></li>
                                @endif
                        
                                @foreach ($employees->getUrlRange(1, $employees->lastPage()) as $page => $url)
                                    @if ($page == $employees->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                        
                                @if ($employees->hasMorePages())
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
    <div wire:ignore.self class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <livewire:employee.employee-form />

        @push('script')
<script>
    $(function() {
        'use strict'

        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }

    });
</script>
@endpush
    </div>
</div>

</div>


@section('custom_script')
@include('layouts.scripts.employee-scripts')
@endsection


