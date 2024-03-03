<div class="content">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item">Activity Logs</li>
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
                                    <h3>Activity Logs</h3>                                  
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
                                    <th>Log Name</th>
                                    <th>Description</th>
                                    <th>Properties</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody >
                                @if ($activities->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">No data available in table.</td>
                                </tr>
                          
                                @else
                                @foreach ($activities as $activity)
                                    <tr >
                                        <td style="font-size: small">{{ $activity->log_name }}</td>
                                        <td style="font-size: small">{{ $activity->description }}</td>
                                        <td style="font-size: small">
                                            @foreach ($activity->properties as $key => $value)
                                            <p>{{ $key }}: {{ is_array($value) ? json_encode($value) : $value }}</p>
                                        @endforeach
                                        
                                        {{-- @foreach ($activity->properties as $key => $value)
                                            @if(is_array($value))
                                                @foreach($value as $nestedKey => $nestedValue)
                                                    <p>{{ $nestedKey }}: {{ $nestedValue }}</p>
                                                @endforeach
                                            @else
                                                <p>{{ $key }}: {{ $value }}</p>
                                            @endif
                                        @endforeach --}}
                                        </td>
                                        <td style="font-size: small">{{ $activity->created_at }}</td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <tfoot>
                        <div class="d-md-flex align-items-center m-2 p-2">
                            <div class="me-md-auto counterHead text-sm-left text-center mb-2 mb-md-0">
                                Showing {{ $activities->firstItem() }} to {{ $activities->lastItem() }} of
                                {{ $activities->total() }}
                                entries
                            </div>

                            <ul class="pagination pagination-separated mb-0 justify-content-center">
                                @if ($activities->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" wire:click="previousPage"
                                            wire:loading.attr="disabled">Previous</a></li>
                                @endif

                                @if ($activities->currentPage() > 2)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $activities->currentPage() - 2 }})">{{ $activities->currentPage() - 2 }}</a>
                                    </li>
                                @endif

                                @if ($activities->currentPage() > 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $activities->currentPage() - 1 }})">{{ $activities->currentPage() - 1 }}</a>
                                    </li>
                                @endif

                                <li class="page-item active"><span
                                        class="page-link">{{ $activities->currentPage() }}</span>
                                </li>

                                @if ($activities->hasMorePages())
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $activities->currentPage() + 1 }})">{{ $activities->currentPage() + 1 }}</a>
                                    </li>
                                @endif

                                @if ($activities->currentPage() < $activities->lastPage() - 1)
                                    <li class="page-item"><a class="page-link"
                                            wire:click="gotoPage({{ $activities->currentPage() + 2 }})">{{ $activities->currentPage() + 2 }}</a>
                                    </li>
                                @endif

                                @if ($activities->hasMorePages())
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
