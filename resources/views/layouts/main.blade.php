<!DOCTYPE html>
<html lang="en">

<head>

    <title>Slazh - @yield('title')</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=yes">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">

    {{-- <script src="https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js"></script> --}}
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>

    {{-- <link rel="manifest" href="manifest.json"> --}}

    <script src=" {{ asset('js/jquery.js') }}"></script>
    <script src=" {{ asset('js/jquery-ui.min.js') }}"></script>
    <!-- <script src=" {{ asset('js/datepicker.min.js') }}"></script> -->
    <script src=" {{ asset('js/jquery.autosize.js') }}"></script>
    <script src=" {{ asset('js/ui-script.js') }}"></script>

    <script src="https://widget-js.cometchat.io/v3/cometchatwidget.js"></script>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />
    <link rel="stylesheet" href="{{ asset('css/tw_element.min.css') }}">
    {{-- <script src="./TW-ELEMENTS-PATH/dist/js/index.min.js"></script> --}}
    <style>
        /* .multiselect__option {
            display: block;
            min-height: 15px;
            line-height: 10px;
        } */
        .multiselect__tags {
            min-height: 33px;
            min-width: 10rem;
            display: block;
            padding: 5px 40px 0 8px;
            border-radius: 5px; 
            border: 1px solid #e8e8e8;
            background: #fff;
            font-size: 14px;
            width: 100% !important;
        }

        /* .multiselect {
            font-size: 16px;
            max-height: 10px !important;
        } */
        .multiselect__single {
            font-size: 14px !important;
            min-width: max-content !important;
            vertical-align: middle !important;
        }

        .multiselect__placeholder {
            margin-bottom: 5px !important;
        }

        .multiselect__content {
            font-size: 14px !important;
        }
    </style>


</head>

<body style="">
    <div id="app" class="overall-container">


        <div class="top-and-side-bar">


            <!-- sidebar -->
            @include('layouts.sidebar')
        </div>
        <div class="main-container" id="main">
            <!-- topbar -->
            @include('layouts.topbar')
            @yield('content')
        </div>

        @yield('script')
    </div>


    <script type="application/javascript">


    // $(document).ready(function () {
    //     $('.pickdate').datepicker({
    //         dateFormat: 'D, dd M yy',
    //         changeYear: true,
    //         changeMonth: true,
    //         showButtonPanel: true,
    //         autoSize: true,
    //         hideIfNoPrevNext: true,
    //         yearRange: "1960:2030",
    //         duration: 'slow',
    //     });

    // });


</script>
<script src=" {{ asset('js/firebase.js') }}"></script>

</body>

</html>
