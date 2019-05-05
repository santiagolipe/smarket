<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ !empty($title) ? ($title . ' - ' . config('app.name', 'Laravel')) : config('app.name', 'Laravel') }}</title>

        @include('includes.favicons')

        @include('includes.fonts')

        @include('includes.styles')

        @include('includes.scripts')
    </head>
    <body>
        <script>window.document.body.classList.add('is-loading');</script>
        <div id="app">
            @yield('content')
        </div>
        @include('includes.body-scripts')
    </body>
</html>
