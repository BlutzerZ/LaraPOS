<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

@yield('custom-css')

<body>
    <div class="container mx-auto">
        @yield('content')
    </div>

    @yield('custom-js')
</body>

</html>
