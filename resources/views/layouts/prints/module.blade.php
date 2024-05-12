<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ ucfirst($customer->last_name) }}, {{ ucfirst($booking->customers->first_name) }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>

<body onload='window.print()''>
    <div class="row mt-4">
        <div class="col-4">
            <h5><strong>CATERING INFORMATION SHEET</strong></h5>
            <div>Name of Client: <strong> {{ ucwords($customer->last_name) }},
                    {{ ucwords($customer->first_name) }}</strong></div>
            <div>Venue Address: <strong>{{ $booking->address->venue_address }} {{ $booking->address->specific_address }},
                    {{ $booking->address->barangay }}, {{ $booking->address->city }}
                    ({{ $booking->address->landmark }})</strong></div>
            <div>Date of Event:
                <strong>{{ $booking['date_event'] ? \Carbon\Carbon::parse($booking['date_event'])->format('F j, Y') : '' }}</strong>
            </div>
            <div>Call Time:
                <strong>{{ $booking['call_time'] ? \Carbon\Carbon::parse($booking['call_time'])->format('g:i A') : '' }}</strong>
            </div>
            <div>Number of Chaffing Dish: </div>
        </div>
        <div class="col-8">
            <h5 class="text-center text-danger">PLEASE READ CAREFULLY</h5>
            <div class="row">
                <div class="col-6">Number of pax booked: <strong>{{ $booking->no_pax }}</strong> Pax</div>
                <div class="col-6">Booked by: </div>
            </div>
            <div>
                Balance: <strong>₱{{ number_format($billing->payable_amt, 2) }}</strong>
            </div>
            <div>

                Motif:
                @if ($booking->color && $booking->color2)
                    <strong>{{ $booking->color }} & {{ $booking->color2 }}</strong>
                @else
                @endif
            </div>
            <div class="row">
                <div class="col-6">Driver: </div>
                <div class="col-6">Server(s): </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="ps-2">
                <div>MENU:</div>
                @foreach ($types as $type)
                    <div class="mt-1">
                        {{ $type->name }}:
                        @foreach ($dishes as $dish)
                            @if ($dish->type_id == $type->id)
                                <div class="row ps-5">{{ $dish->name }}</div>
                            @endif
                        @endforeach
                        @foreach ($addons as $addon)
                            @if ($addon->type_id == $type->id)
                                <div class="row ps-5">{{ $addon->name }} / Add-on</div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-8">
            <div class="row">
                <div class="col-6">
                    <div>CATERING EQUIPMENT:</div>
                    {{-- @foreach (['Canopy', 'Chairs', 'Chair Cloth'] as $equipment)
                        <div class="mt-1">{{ $equipment }}: </div>
                    @endforeach --}}
                    <div class="mt-2">
                        <?php
                        $numCanopy = 1;
                        ?>
                        <div class="mt-1">Canopy: <strong>{{ $numCanopy }}</strong></div>
                        <div class="mt-1">Chairs: <strong>{{ $booking->no_pax }}</strong></div>
                        <div class="mt-1">Chair Cloth: <strong>{{ $booking->no_pax }}</strong></div>
                    </div>
                    <div class="mt-2">
                        Table
                        <div class="ps-4">
                            <?php
                            $numTables = ceil($booking->no_pax / 10); // Calculate number of 10-seater tables
                            $numSquareTables = 2; // Default number of Square tables
                            $lechonTable = 1;
                            
                            // Adjust the number of Square tables based on the number of guests
                            if ($booking->no_pax >= 200) {
                                $numSquareTables += 2;
                                $lechonTable += 1; // Increase by 1 if there are 50 or more guests
                            } elseif ($booking->no_pax >= 600) {
                                $numSquareTables += 4; // Increase by 2 if there are 100 or more guests
                                $lechonTable += 2;
                            }
                            
                            ?>
                            <div>10 Seater: <strong>{{ $numTables }} Guest + {{ $numSquareTables }} Buffet</strong>
                            </div>
                            <div>Square: <strong>{{ $numSquareTables }} Buffet</strong></div>
                            <div>Round: </div>
                            <div>Lechon: <strong>{{ $lechonTable }} Wood</strong></div>
                            <div>Wood: </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <?php
                        $numPlatito = 20;
                        $canopyLace = 4 * $numCanopy;
                        $chairLace = $booking->no_pax / 2;
                        $lace = $booking->no_pax;
                        $numHanky = $booking->no_pax / 2;
                        $hanky = $booking->no_pax;
                        
                        if ($booking->no_pax >= 200) {
                            $numPlatito += 20;
                        } elseif ($booking->no_pax >= 300) {
                            $numPlatito += 40;
                        }
                        
                        ?>
                        <div class="mt-1">Drop 2.5: <strong>{{ $numTables }}</strong></div>
                        <div class="mt-1">Chair Lace: @if ($booking)
                                <strong>{{ $chairLace }}
                                    {{ $booking->color }} & {{ $chairLace }} {{ $booking->color2 }}</strong>
                            @else
                                <strong>{{ $lace }}</strong>
                            @endif
                        </div>
                        <div class="mt-1">Canopy Lace: <strong>{{ $canopyLace }}</strong></div>
                        <div class="mt-1">Goblet: <strong>{{ $booking->no_pax }}</strong></div>
                        <div class="mt-1">Highball Glass: </div>
                        <div class="mt-1">Hanky:
                            @if ($booking->color && $booking->color2)
                                <strong>{{ $numHanky }} {{ $booking->color }} & {{ $numHanky }}
                                    {{ $booking->color2 }}</strong>
                            @else
                                <strong>{{ $hanky }}</strong>
                            @endif
                        </div>
                        <div class="mt-1">Plate: <strong>{{ $booking->no_pax }}</strong></div>
                        <div class="mt-1">Spoon and Fork:
                            <strong>{{ $booking->no_pax }}/{{ $booking->no_pax }}</strong>
                        </div>
                        <div class="mt-1">Platito: <strong>{{ $numPlatito }}</strong></div>
                        <div class="mt-1">Kutsarita: <strong>{{ $numPlatito }}</strong></div>
                        <div class="mt-1">Dessert Bowl: </div>
                        <div class="mt-1">Soup Bowl: </div>
                    </div>
                </div>
                <div class="col-6">
                    <div>____________________________________________________</div>
                    {{-- @foreach (['Serving Spoon', 'Serving Fork', 'Clip Big', 'Clip Small', 'Pitcher', 'Softdrinks Bowl', 'Knife', 'Scissors', 'Lechon Tray', 'Cake Stand', 'Soup Warmer', 'Special Request'] as $requestItem)
                        <div class="mt-1">{{ $requestItem }}: </div>
                    @endforeach --}}
                    <div class="mt-1">Serving Spoon: <strong>{{ $booking->no_pax <= 75 ? 8 : 10 }}</strong></div>
                    <div class="mt-1">Serving Fork: <strong>{{ $booking->no_pax <= 75 ? 2 : 4 }}</strong></div>
                    <div class="mt-1">Clip Big: <strong>{{ $booking->no_pax <= 75 ? 2 : 3 }}</strong></div>
                    <div class="mt-1">Clip Small: <strong>{{ $booking->no_pax <= 75 ? 2 : 3 }}</strong></div>
                    <div class="mt-1">Pitcher: <strong>{{ $booking->no_pax <= 75 ? 2 : 5 }}</strong></div>
                    <div class="mt-1">Softdrinks Bowl: <strong>{{ $booking->no_pax <= 75 ? 1 : 2 }}</strong></div>
                    <div class="mt-1">Knife: <strong>{{ $lechonTable }}</strong></div>
                    <div class="mt-1">Scissors: <strong>{{ $lechonTable }}</strong></div>
                    <div class="mt-1">Lechon Tray: <strong>{{ $lechonTable }}</strong></div>
                    <div class="mt-1">Cake Stand: </div>
                    <div class="mt-1">Soup Warmer: </div>
                    <div class="mt-1">Special Request: </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
