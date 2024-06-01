<div class="content">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item">Payment Proofs</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        @if ($proofs->isEmpty())
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    No payment proofs found.
                </div>
            </div>
        @else
            @foreach ($proofs as $proof)
                <div class="col-12 col-md-6 col-xl-6 d-flex mb-3">
                    <div class="card report-blk">
                        <div class="card-body">
                            <img src="{{ asset('storage/images/' . $proof->photo) }}" alt="Payment Proof" class="img-fluid">
                            <div class="mt-3">
                                <small>{{ \Carbon\Carbon::parse($proof->created_at)->format('j-F-Y, g:i a') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
