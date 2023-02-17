<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Login | MIG - IS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet" type="text/css" />

        <script src="{{ asset('backend/assets/js/modernizr.min.js') }}"></script>

    </head>


    <body class="account-pages">

        <!-- Begin page -->
        <div class="accountbg" style="background: url({{ asset('backend/assets/images/original_login.jpg') }});background-size: cover;background-position: center;"></div>

        <div class="wrapper-page account-page-full">

            <div class="card">
                <div class="card-block">

                    <div class="account-box">

                        <div class="card-box p-5">
                            <h2 class="text-uppercase text-center pb-4">
                                <a href="index.html" class="text-success">
                                    <span><img src="{{ asset('backend/assets/images/logo-mig.svg') }}" alt="" height="50"></span>
                                </a>
                            </h2>

                            @if($message = Session::get('danger'))
                            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" id="callout" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{ $message }}
                            </div>
                            @endif
                            <form class="" method="POST" action="{{ route('login') }}">
                            @csrf
                                <div class="form-group m-b-20 row">
                                    <div class="col-12">
                                        <label for="emailaddress">Email / NIK</label>
                                        <input class="form-control" name="email" required="" placeholder="Enter your email / nik">
                                    </div>
                                </div>

                                <div class="form-group row m-b-20">
                                    <div class="col-12">
                                        <a href="{{ route('forgot') }}" class="text-muted float-right"><small>Forgot your password?</small></a>
                                        <label for="password">Password</label>
                                        <input class="form-control" name="password" type="password" required="" id="password" placeholder="Enter your password">
                                    </div>
                                </div>

                                <div class="form-group row m-b-20">
                                    <div class="col-12">

                                        <div class="checkbox checkbox-primary" hidden>
                                            <input id="remember" type="checkbox" checked="">
                                            <label for="remember">
                                                Remember me
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row text-center m-t-10">
                                    <div class="col-12">
                                        <button class="btn btn-block btn-primary waves-effect waves-light" type="submit">Sign In</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center">
                <p class="account-copyright">2019 © PT Molindo Inti Gas. - by. IT Team</p>
            </div>

        </div>



        <!-- jQuery  -->
        <script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/waves.js') }}"></script>
        <script src="{{ asset('backend/assets/js/jquery.slimscroll.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('backend/assets/js/jquery.core.js') }}"></script>
        <script src="{{ asset('backend/assets/js/jquery.app.js') }}"></script>

        <script>
            $(function () {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajaxSetup({

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }

                });

                setTimeout(function () {
                    $('#callout').show().addClass('animated fadeOutDown').fadeOut();
                }, 3000);

                @if($message = Session::get('success'))
                    $.toast({
                        text: '{{ $message }}',
                        heading: 'MIG-IS',
                        showHideTransition: 'plain',
                        position: 'top-right',
                        loaderBg: '#5ba035',
                        icon: 'success',
                        hideAfter: 3000,
                        stack: 1
                    })
                @elseif($message = Session::get('warning'))
                    $.toast({
                        text: '{{ $message }}',
                        heading: 'MIG-IS',
                        showHideTransition: 'plain',
                        position: 'top-right',
                        loaderBg: '#da8609',
                        icon: 'warning',
                        hideAfter: 3000,
                        stack: 1
                    })
                @elseif($message = Session::get('danger'))
                    $.toast({
                        text: '{{ $message }}',
                        heading: 'MIG-IS',
                        showHideTransition: 'plain',
                        position: 'top-right',
                        loaderBg: '#bf441d',
                        icon: 'error',
                        hideAfter: 3000,
                        stack: 1
                    })
                @endif
                // setTimeout(function () {
                //     notify.close();
                // }, 3000);

            });

        </script>

    </body>
</html>