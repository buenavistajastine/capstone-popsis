<div class="content">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item">QR Code</li>
                </ul>
            </div>
        </div>
    </div>
    @forelse ($qrcodes as $qrcode)
    @empty
        <div class="col-md-4">
            <div class="btn-group">
                <a class="btn btn-primary" wire:click="createQR">
                    <i class="fa-solid fa-qrcode me-2"></i> Add QR Code
                </a>
            </div>
        </div>
    @endforelse
    <div class="row justify-content-center align-items-center">
   

        @foreach ($qrcodes as $qrcode)
            <div class="col-12 col-md-6 col-xl-6 d-flex align-items-center justify-content-center">
                <div class="card report-blk">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <img src="{{ asset('storage/qrCode/' . $qrcode->qr_code) }}" alt="QR Code" width="100%"
                                height="100%">
                        </div>
                        <div class="btn-group" role="group">
                            <a class="btn btn-primary btn-sm mx-1" wire:click="editQR({{ $qrcode->id }})">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a class="btn btn-danger btn-sm mx-1" wire:click="deleteQR({{ $qrcode->id }})"
                                title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div wire.ignore.self class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModal" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <livewire:q-r.q-r-form />
    </div>
</div>

@section('custom_script')
    @include('layouts.scripts.booking-scripts')
@endsection
