<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Highdmin - Responsive Bootstrap 4 Admin Dashboard</title>
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
        <div class="accountbg" style="background: url({{ asset('backend/assets/images/login.jpg') }});background-size: cover;background-position: center;"></div>

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

                            <div class="text-center m-b-20">
                                <p class="text-muted m-b-0">Enter your email address and we'll send you an email with instructions to reset your password.  </p>
                            </div>

                            <form class="form-horizontal" action = "{{ route('auth.forgot') }}" method = "post">
								@csrf
								
                                <div class="form-group row m-b-20">
                                    <div class="col-12">
                                        <label for="emailaddress">Email address</label>
                                        <input class="form-control" type="email" id="emailaddress" name="email_Address"  placeholder="example@molindointigas.co.id" required>
                                    </div>
                                </div>

                                <div class="form-group row text-center m-t-10">
                                    <div class="col-12">
                                        <button class="btn btn-block btn-custom waves-effect waves-light" type="submit">Reset Password</button>
                                    </div>
                                </div>

                            </form>

                            <div class="row m-t-50">
                                <div class="col-sm-12 text-center">
                                    <p class="text-muted">Back to <a href="{{ route('login') }}" class="text-dark m-l-5"><b>Sign In</b></a></p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center">
                <p class="account-copyright">2019 © PT Molindo Inti Gas. - by. IT Team</p>
            </div>

        </div>



        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/metisMenu.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>
</html>