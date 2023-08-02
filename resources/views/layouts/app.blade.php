<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
</head>

<body>
    <div class="container">
        @include('partials.sidebar', ['menus' => $menus])
        @yield('content')
    </div>
</body>

</html>
