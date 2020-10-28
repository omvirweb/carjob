<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 <head>
         <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="{{ asset('frontend/plugins/bootstrap-4.3.1/dist/css/bootstrap.min.css') }}">
        <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
        <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
        <script src="{{ asset('frontend/plugins/bootstrap-4.3.1/dist/js/bootstrap.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    </head>
    <body>

        <div class="jumbotron text-center pt-2 pb-2 mb-0">
            <h2> <img src="{{ asset('frontend//images/shreejewels_logo.svg') }}" style="width:280px; height:auto;"></h2>
        </div>

        <div class="container mt-3 mb-3">

           @yield('content')
        </div>

        <div class="jumbotron text-center pt-3 pb-2 mb-0">
            <p>Footer</p>
        </div>

    </body>
</html>
