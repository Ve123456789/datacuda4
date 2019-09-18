<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Datacuda</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<script>window.Laravel = { csrfToken: '{{ csrf_token() }}' } </script>
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
    <link rel="stylesheet" href="{{url('assets/css/datacuda.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/cory.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/responsive_cory.css')}}">
    <script src="{{ url('assets/external_js/Chart.min.js') }}"></script>
    <script src="{{ url('assets/external_js/utils.js') }}"></script>
    <script src="{{ url('assets/external_js/dropzone.js') }}"></script>
</head>
<body>
    <div id="app">
        <vue-layout></vue-layout>
    </div>
    
    <script src="{{ url('js/app.js') }}"></script>
    <!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->
    <script src="{{ url('assets/external_js/jquery-3.3.1.min.js') }}"></script>
    

    <script src="{{ url('assets/external_js/bootstrap.min.js') }}" ></script>
    
    <script src="{{ url('assets/external_js/datepicker.min.js') }}"></script>
    <script src="{{ url('assets/external_js/datepicker.en.js') }}"></script>
    <script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>
    <script src="{{ url('assets/external_js/owl.carousel.min.js') }}"></script>
    <script src="{{ url('assets/external_js/cory.js') }}" ></script>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://wchat.freshchat.com/js/widget.js"></script>
    <script>
      window.fcWidget.init({
        token: "83946b25-321f-44ee-8826-914f361fa918",
        host: "https://wchat.freshchat.com"
      });
    </script>
    <script>
        // Make sure fcWidget.init is included before setting these values

        // To set unique user id in your system when it is available
        window.fcWidget.setExternalId("john.doe1987");

        // To set user name
        window.fcWidget.user.setFirstName("John");

        // To set user email
        window.fcWidget.user.setEmail("john.doe@gmail.com");

        // To set user properties
        window.fcWidget.user.setProperties({
        plan: "Estate", // meta property 1
        status: "Active" // meta property 2
        });
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics --> 
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-142146779-1"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-142146779-1'); </script>
@yield('pagespecificscripts')
</body>

</html>



