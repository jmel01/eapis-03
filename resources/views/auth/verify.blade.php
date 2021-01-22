<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'NCIP-EAPIS') }} | Verify Email Address</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/app/NCIP_logo150x150.png') }}" type="image/x-icon" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="/">
                <img src="{{ asset('images/app/NCIP_logo150x150.png') }}" alt="{{ config('app.name', 'NCIP-EAPIS') }} Logo" class="img-circle" style="height:50px;">
                <b>NCIP</b>EAPIS
            </a>
        </div>

        <div class="card text-center">
            <div class="card-body login-card-body">
                <p class="login-box-msg"><strong> Verify Your Email Address</strong></p>

                @if (session('resent'))
                <div class="rounded p-2 mb-2" style="color: #1d643b; background-color: #d7f3e3; border-color: #c7eed8;">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <p>Before proceeding, please check your email for a verification link. If you did not receive the email,
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">click here to request another</button>
                            </p>
                        </form>
                    </div>

                    <div class="col-12">
                        <a href="#" class="btn btn-primary btn-sm float-center" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('/bower_components/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/bower_components/admin-lte/dist/js/adminlte.min.js') }}"></script>

</body>

</html>