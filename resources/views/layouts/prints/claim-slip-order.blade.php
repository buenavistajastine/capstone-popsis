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
        /* @font-face {
            font-family: 'FigTree';
            src: url('https://fonts.bunny.net/figtree/fontfile.woff2') format('woff2'); */
        /* Add additional font formats for cross-browser compatibility */
        /* } */

        html,
        body {
            color: black;
            font-size: 12px;
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
    </style>
</head>

<body onload='window.print()''>
    <div class="claim-slip-container" id="contentToPrint">
        <div class="row">
            <div class="col-12 p-2 text-center">
                <div>
                    <h1 class="fw-bold">POPSI'S</h2>
                </div>
                <div class="fon">Prepared by our Family, for your Family
                </div>
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
                    <div class="col-12 mt-2"><strong>
                            <h4 class="text-center">Claim Slip</h3>
                        </strong></div>
                </div>
            </div>
            <hr>
        </div>


        <div class="row">
            <div class="col-md-6">ORDER NO: {{ $order->order_no }} <span
                    class="float-end">{{ $billing->statuses->name }}</div>
            <div class="col-md-12">DATE: <span>{{ $date }}</span></div>
            <div class="col-md-12">DATE OF DELIVERY:
                <span>{{ $order['date_need'] ? \Carbon\Carbon::parse($order['date_need'])->format('F j, Y') : '' }}
                    at
                    {{ $order['call_time'] ? \Carbon\Carbon::parse($order['call_time'])->format('g:i A') : '' }}
                </span>
            </div>
            <div class="col-md-12">CUSTOMER: <span>{{ $billing->customers->last_name }},
                    {{ $billing->customers->first_name }}</span></div>

            <div class="col-md-12">DISHES: </div>
            @foreach ($dish_keys as $key)
                <div class="ps-4">{{ $key->dishes->name }}</div>
            @endforeach
            <hr class="mt-3">
            <div class="col-md-12 mt-1">TOTAL AMOUNT: <span class="float-end"><strong>₱
                        {{ number_format($order->total_price, 2) }}</strong></span></div>
        </div>
    </div>
</body>

</html>
