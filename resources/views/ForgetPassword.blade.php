<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Datacuda</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('assets/img/fav.png')}}">
    <!-- for develop css -->
    <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/owl.theme.default.min.css')}}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- style css -->
    <link rel="stylesheet" href="{{url('assets/css/datepicker.min.css')}}">

    <link rel="stylesheet" href="{{url('assets/css/cory.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/responsive_cory.css')}}">

</head>
<body>

<div id="app">
    <vue-reset-layout></vue-reset-layout>
</div>

<script src="/js/app.js"></script>


<script src="{{ url('assets/external_js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ url('assets/external_js/bootstrap.min.js') }}" ></script>
<script src="{{ url('assets/external_js/owl.carousel.min.js') }}"></script>
<script src="{{ url('assets/external_js/cory.js') }}" ></script>
<script src="{{ url('assets/external_js/datepicker.min.js') }}"></script>
<script src="{{ url('assets/external_js/datepicker.en.js') }}"></script>

@yield('pagespecificscripts')

</body>
</html>



