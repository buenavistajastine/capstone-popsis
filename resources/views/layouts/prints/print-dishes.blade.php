<!-- resources/views/dishes/print.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Dishes</title>
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}"> --}}
    <!-- Add any additional styles or scripts needed for formatting -->
    <style>
        .ps-3 {
            padding-left: 20px,
        }
    </style>
</head>
<body onload='window.print()''>

    @foreach ($groupedDishes as $menuName => $menuDishes)
    <h2>{{ $menuName }}</h2>
    <div>
        @foreach ($menuDishes as $item)
            <div class="ps-3">
                <span>{{ $item['dish']->name ?? '' }}</span>
                <span>x {{ $item['quantity'] ?? '' }}</span>
            </div>
        @endforeach
    </div>
@endforeach


    {{-- @foreach ($groupedDishes as $menuName => $menuDishes)
    <h2>{{ $menuName }}</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Dish Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menuDishes as $item)
                <tr>
                    <td>{{ $item['dish']->name ?? '' }}</td>
                    <td>{{ $item['quantity'] ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach --}}


</body>
</body>
</html>
