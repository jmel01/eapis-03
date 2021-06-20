<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NCIP-EAPIS') }}</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.css" integrity="sha512-Ho1L8FTfzcVPAlvfkL1BV/Lmy1JDUVAP82/LkhmKbRX5PnQ7CNDHAUp2GZe7ybBpovS+ssJDf+SlBOswrpFr8g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css" integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <style>
        .form-control[readonly] {
            background-color: #fff;
        }

        .form-control[disabled] {
            background-color: #fff;
        }

        .profile-user-img {
            width: 200px;
            height: 200px;
        }

        .fill {
            object-fit: fill;
        }

        .contain {
            object-fit: contain;
        }

        .cover {
            object-fit: cover;
        }

        .scale-down {
            object-fit: scale-down;
        }

        .none {
            object-fit: none;
        }
    </style>


    @stack('style')

</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">

        @include('layouts.adminlte.topbar')

        @include('layouts.adminlte.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('layouts.adminlte.contentheader')

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        @include('layouts.adminlte.controlsidebar')

        @include('layouts.adminlte.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <!-- overlayScrollbars -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/OverlayScrollbars.min.js" integrity="sha512-B1xv1CqZlvaOobTbSiJWbRO2iM0iii3wQ/LWnXWJJxKfvIRRJa910sVmyZeOrvI854sLDsFCuFHh4urASj+qgw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js" integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch (type) {
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
    </script>

    @stack('scripts')

</body>

</html>