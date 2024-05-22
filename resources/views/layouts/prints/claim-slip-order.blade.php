<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title style="text-transform: capitalize;">Claim Slip - {{ $order->customers->first_name }}
        {{ $order->customers->last_name }}</title>
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
            font-size: 10px;
            font-family: 'Colombo', sans-serif;
        }

        /* body {
            font-family: 'Arial', sans-serif;        } */
        .marg {
            padding-left: 5px;
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
            font-size: 10px;
        }

        .claim-slip-container {
            width: 100%;
            margin: 0 auto;
        }

        .fon {
            font-size: 12px;

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

        .receipt-header {
            font-size: 16px;
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
            <div class="col-md-12 d-flex justify-content-center text-center">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center header-font" style="margin-bottom:-5px">
                        Luzariaga St.
                    </div>
                    <div class="col-12 d-flex justify-content-center header-font" style="margin-bottom:-5px">
                        Valencia, Negros Oriental
                    </div>
                    <div class="col-12 d-flex justify-content-center header-font" style="margin-bottom:-5px">
                        Tel.Nos. 09458613737
                    </div>

                </div>
            </div>
            <hr class="broken-line mt-3">
        </div>

        <div class="row">
            <div class="col-md-12 text-center"><h3>{{ $order->transports->name }}</h3></div>
            <div class="col-md-6">ORDER NO: {{ $order->order_no }} <span class="float-end">{{ $billing->statuses->name }}</span></div>
            <div class="col-md-12">DATE: <span>{{ $date }}</span></div>
            <div class="col-md-12">DATE OF DELIVERY:
                <span>{{ $order['date_need'] ? \Carbon\Carbon::parse($order['date_need'])->format('F j, Y') : '' }} at {{ $order['call_time'] ? \Carbon\Carbon::parse($order['call_time'])->format('g:i A') : '' }}</span>
            </div>
            <div class="col-md-12">CUSTOMER: <span>{{ $billing->customers->last_name }}, {{ $billing->customers->first_name }}</span></div>

            <div class="col-md-12">DISHES: </div>
            @foreach ($dish_keys as $key)
            @php
                $total_price = 0;
                if ($key->quantity >= 1) {
                    $total_price += ($key->dishes->price_full * $key->quantity);
                } elseif ($key->quantity == 0.5) {
                    $total_price += $key->dishes->price_half;
                }
            @endphp
                <div class="ps-4">{{ $key->dishes->name }} X{{ $key->quantity }}  <span class="float-end">{{ number_format($total_price, 2) }}</span></div>
            @endforeach
            <hr class="broken-line mt-3">
            <div class="col-md-12 mt-1">TOTAL AMOUNT: <span class="float-end"><strong>₱{{ number_format($order->total_price, 2) }}</strong></span></div>
            <div class="col-md-12 mt-1">PAID AMOUNT: <span class="float-end"><strong>₱{{ number_format($billing->paidAmount()->where('billing_id', $billing->id)->sum('paid_amt'), 2) }}</strong></span></div>
            <div class="col-md-12 mt-1">BALANCE: <span class="float-end"><strong>₱{{ number_format($billing->paidAmount->payable_amt, 2) }}</strong></span></div>

        </div>
        <div class="row">
            <div class="col-md-12 text-center mt-3">** NOT AN OFFICIAL RECEIPT **</div>
        </div>
    </div>
</body>

</html>
