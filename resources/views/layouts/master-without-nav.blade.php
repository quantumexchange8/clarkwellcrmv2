<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>

    <title>@yield('title') | Clark Well</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/CW-icon.png') }}"/>
    <link rel="apple-touch-icon" href="{{ asset('img/CW-icon.png') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 relative bg-no-repeat bg-cover" style="background-image: url('{{asset('img/background.jpg')}}')">
        @yield('contents')
        @include('sweetalert::alert')
    </div>
<script src="{{ asset('dist/datepicker.js') }}"></script>
<script src="{{ asset('dist/flowbite.min.js') }}"></script>
<script src="{{ asset('dist/index.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/datepicker.min.js"></script>
@yield('script')
</body>
</html>
