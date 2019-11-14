
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-base-url" content="{{ url('/api') }}" />
    <meta name="root-url" content="{{ env('ROOT_URL', '/') }}">
    <meta name="base-url" content="{{ url('/') }}">

    <title>Ultimate Eats</title>
    <script src="{{ asset('public/js/app.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body class="hold-transition sidebar-mini">
        

<div class="wrapper" id="app">
    <!-- REQUIRED SCRIPTS -->

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
</form>
</div>
<!-- ./wrapper -->


</body>
</html>
