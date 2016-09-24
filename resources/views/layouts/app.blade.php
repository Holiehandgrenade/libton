<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="_token" value="{{ csrf_token() }}">
    <title>Laravel</title>

    <!-- Fonts -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/handsontable/0.27.0/handsontable.full.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.css" rel="stylesheet" />
    <!-- Styles -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}

    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">




    <script src="https://js.pusher.com/3.2/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
//        Pusher.logToConsole = true;

        // App Id
        var pusher = new Pusher('26fb76f462d597dc6e9d', {
            encrypted: true
        });
    </script>



    <style>
        html, body, body > .container-fluid,
        body > .container-fluid > .row,
        body > .container-fluid > .row > div,
        body > .container-fluid > .row > div > div.full-height {
            height: 100%;
        }
        
        body {
            /* Fallback to Helvetica if Lato is unavailable
               mostly if working offline
            */
            font-family: 'Helvetica', sans-serif;
            font-family: 'Lato', sans-serif;
            
            overflow: hidden;
            
            /* for bootstrap fixed top nav */
            padding-top: 51px;
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>

<body id="app-layout">
    @if(Auth::check())
        @include('nav.top.user')
    @else
        @include('nav.top.guest')
    @endif


    
    <div class="container-fluid">
        <div class="row">
            {{--Left Nav if needed--}}

            {{--@if(Auth::check())--}}
                {{--<div class="col-md-2">--}}
                    {{--@include('nav.left.main')--}}
                {{--</div>--}}
            {{--@endif--}}

            <div class="col-md-{{ Auth::check() ? '10' : '12' }} overflow-auto">
                <div class="padding-top-md padding-bottom-md full-height">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>



    <!-- JavaScripts -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGZHCtD6VFsnmxzSfhObo3bTlZM5OB-RI&callback=app.init"></script>
</body>
</html>
