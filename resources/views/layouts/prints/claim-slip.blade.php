<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title style="text-transform: capitalize;">Claim Slip - {{ $booking->customers->first_name }} {{ $booking->customers->last_name }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
        @font-face {
            font-family: 'Colombo';
            src: url('{{ asset('assets/fonts/Colombo.ttf') }}') format('truetype');
        }

        html,
        body {
            color: black;
            font-size: 11px;
            font-family: 'Colombo', sans-serif;
        }

        .service-item {
            display: flex;
            justify-content: space-between !important;
        }

        .colspan-6 {
            width: 50%;
            float: left;
        }

        .header-font {
            font-size: 12px;
        }

        .claim-slip-container {
            width: 100%;
            margin: 0 auto;
        }

        .fon {
            font-size: 12px;
        }
        .receipt-header {
            font-size: 16px;
        }

        .logo {
            width: 75%;
            margin-bottom: -10px;
            margin-top: -17px;
        }

        .broken-line {
            border: none;
            border-top: 1px dashed #000;
            /* Adjust color and thickness as needed */
        }
    </style>
</head>

<body onload='window.print()'>
    <div class="claim-slip-container" id="contentToPrint">
        <div class="row">
            <div class="col-12 p-2 text-center">
                <div>
                    <h1 class="fw-bold receipt-header">POPSI'S</h1>
                </div>
                <div class="fon">Prepared by our Family, for your Family</div>
            </div>
            <div class="col-12 text-center">
                <div class="row">
                    <div class="col-12 header-font" style="margin-bottom:-5px">Luzariaga St.</div>
                    <div class="col-12 header-font" style="margin-bottom:-5px">Valencia, Negros Oriental</div>
                    <div class="col-12 header-font" style="margin-bottom:-5px">Tel.Nos. 09458613737</div>
                </div>
            </div>
            <hr class="broken-line mt-3">
        </div>

        <div class="row">
            <div class="col-md-6">{{ $booking->booking_no }} <span class="float-end">{{ $billing->statuses->name }}</span></div>
            <div class="col-md-12">DATE: <span>{{ $date }}</span></div>
            <div class="col-md-12">CUSTOMER: <span>{{ $billing->customers->last_name }}, {{ $billing->customers->first_name }}</span></div>
        </div>

        <div class="row">
            <div class="col-md-6">PACKAGE: <span>{{ $booking->packages->name }}</span></div>
            <div class="col-md-6 text-end">{{ number_format($booking->packages->price, 2) }}/PAX</div>
        </div>

        <div class="row">
            <div class="col-md-6">NO. OF GUESTS: <span class="float-end">{{ $booking->no_pax }} Pax</span></div>
        </div>

        <div class="row">
            <div class="col-md-12">DISHES & ADD-ONS: </div>
            @foreach ($dish_keys as $key)
                <div class="col-md-12 ps-4">{{ $key->dishes->name }}</div>
            @endforeach
            @foreach ($add_ons as $dish)
            @php
                $total_price = 0;
                if ($dish->quantity >= 1) {
                    $total_price += ($dish->dishss->price_full * $dish->quantity); 
                } elseif ($dish->quantity == 0.5) {
                    $total_price += $dish->dishss->price_half;
                }
            @endphp
                <div class="col-md-12 ps-4">Add-on: {{ $dish->dishss->name }} <span class="float-end">{{ number_format($total_price, 2) }}</span></div>
            @endforeach
        </div>

        <hr class="broken-line mt-3">
        <div class="row">
            <div class="col-md-12 mt-1 mb-1">TOTAL AMOUNT: <span class="float-end"><strong>₱{{ number_format($booking->total_price, 2) }}</strong></span></div>

            @if ($billing->additional_amt != 0)
            <div class="col-md-12 mt-1">ADDITIONAL AMOUNT: <span class="float-end"><strong>₱{{ number_format($billing->additional_amt, 2) }}</strong></span></div>
            @endif
            @if ($billing->advance_amt != 0)
            <div class="col-md-12 mt-1">ADVANCE AMOUNT: <span class="float-end"><strong>₱{{ number_format($billing->advance_amt, 2) }}</strong></span></div>
            @endif
            @if ($billing->discount_amt != 0)
            <div class="col-md-12 mt-1 mb-2">DISCOUNT AMOUNT: <span class="float-end"><strong>₱{{ number_format($billing->discount_amt, 2) }}</strong></span></div>
            @endif 

            <div class="col-md-12 mt-1">PAID AMOUNT: <span class="float-end"><strong>₱{{ number_format($billing->paidAmount()->where('billing_id', $billing->id)->sum('paid_amt'), 2) }}</strong></span></div>
            <hr class="broken-line mt-3">
            <div class="col-md-12">BALANCE: <span class="float-end"><strong>₱{{ number_format($billing->paidAmount->payable_amt, 2) }}</strong></span></div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center mt-3">** NOT AN OFFICIAL RECEIPT **</div>
        </div>
    </div>
</body>

</html>
