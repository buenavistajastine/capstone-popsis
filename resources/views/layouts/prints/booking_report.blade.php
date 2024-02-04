<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">

    
</head>
<body onload='window.print()''>
    @foreach($groupedDishes as $menuId => $dishes)
        <h2>Menu ID: {{ $menuId }}</h2>
        <ul>
            @foreach($dishes as $dish)
                <li>{{ $dish->name }} - {{ $dish->description }}</li>
            @endforeach
        </ul>
    @endforeach
</body>
</html>