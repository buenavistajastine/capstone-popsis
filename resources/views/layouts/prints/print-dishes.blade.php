<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Dishes</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Add any additional styles or scripts needed for formatting -->
    <style>
        .ps-3 {
            padding-left: 20px; /* Corrected syntax: use semicolon instead of comma */
        }
    </style>
</head>

<body onload='window.print()''>

    <div class="row flex-row "> <!-- Start a single row here -->
        @foreach ($groupedDishes as $menuName => $menuDishes)
            <div class="col-md-3 mb-3">
                <h4>{{ $menuName }}</h4>
                <div>
                    @foreach ($menuDishes as $item)
                        <div class="ps-2">
                            <span>{{ $item['dish']->name ?? '' }}</span>
                            <span>x {{ $item['quantity'] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div> <!-- End the single row here -->

</body>

</html>
