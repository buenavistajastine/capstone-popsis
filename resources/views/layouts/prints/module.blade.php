<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $customer->last_name }}, {{ $booking->customers->first_name }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">

    
</head>
<body onload='window.print()''>
    {{-- @foreach($dishes as $dish)
    {{ $dish->name }}
    @endforeach --}}
    <div class="row mt-4">
        <div class="col-4">
            <h5><strong>CATERING INFORMATION SHEET</strong></h5>
            <div>Name of Client: <strong> {{ ucwords($customer->last_name) }}, {{ ucwords($customer->first_name) }}</strong></div>
            <div>Venue Address: <strong>{{ $booking->venue_address }}</strong></div>
            <div>Date of Event: <strong>{{ $booking['date_event'] ? \Carbon\Carbon::parse($booking['date_event'])->format('F j, Y') : '' }}</strong></div>
            <div>Call Time: <strong>{{ $booking['call_time'] ? \Carbon\Carbon::parse($booking['call_time'])->format('g:i A') : '' }}</strong></div>
            <div>Number of Chaffing Dish: </div>
        </div>
        <div class="col-8">
            <h5 class="text-center text-danger">PLEASE READ CAREFULLY</h5>
            <div class="row">
                <div class="col-6">Number of pax booked: {{ $booking->no_pax }} Pax</div>
                <div class="col-6">Booked by: </div>
            </div>
            <div>
                Balance: 
            </div>
            <div>
                Motif: 
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
        
                @foreach (['Rice' => 1, 'Dessert' => 9, 'Main' => [2, 3, 4, 5], 'Pasta/Noddles' => 6, 'Vegetable/Salad' => 7, 'Soup' => 1] as $category => $menuId)
                    <div class="mt-1">
                        {{ $category }}:
                        @foreach ($dishes as $dish)
                            @if (is_array($menuId) ? in_array($dish->menu_id, $menuId) : $dish->menu_id == $menuId)
                                <div class="row ps-5">{{ $dish->name }}</div>
                            @endif
                        @endforeach

                        @foreach ($addons as $addon)
                            @if (is_array($menuId) ? in_array($addon->menu_id, $menuId) : $addon->menu_id == $menuId)
                                <div class="row ps-5 fw-bold">{{ $addon->name }}</div>
                            @endif
                        @endforeach

                    </div>
                @endforeach
        
            </div>
        </div>
        

        <div class="col-8">
            <div class="row">
                {{-- for equipment column --}}
                <div class="col-6">
                    <div>CATERING EQUIPMENT:</div>
                    
                    @foreach (['Canopy', 'Chairs', 'Chair Cloth'] as $equipment)
                        <div class="mt-1">{{ $equipment }}: </div>
                    @endforeach
        
                    <div class="mt-2">
                        Table
                        <div class="ps-4">
                            @foreach (['10 seater', 'Square', 'Round', 'Lechon', 'Wood'] as $tableType)
                                <div>{{ $tableType }}: </div>
                            @endforeach
                        </div>
                    </div>

                    @foreach (['Drop 2.5', 'Chair Lace', 'Chafing Lace', 'Canopy Lace', 'Goblet', 'Highball Glass', 'Hanky', 'Plate', 'Spoon and Fork', 'Platito', 'Kutsarita', 'Dessert Bowl', 'Soup Bowl'] as $equipment)
                        <div class="mt-1">{{ $equipment }}: </div>
                    @endforeach
                </div>
        
                {{-- for request column --}}
                <div class="col-6">
                    <div>____________________________________________________</div>
                    
                    @foreach (['Serving Spoon', 'Serving Fork', 'Clip Big', 'Clip Small', 'Pitcher', 'Softdrinks Bowl', 'Knife', 'Scissors', 'Lechon Tray', 'Cake Stand', 'Soup Warmer', 'Special Request'] as $requestItem)
                        <div class="mt-1">{{ $requestItem }}: </div>
                    @endforeach
                </div>
            </div>
        </div>
        


    </div>
</body>
</html>