<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>@yield('title') | MIG - IS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Plugin css -->
        <link href="{{ asset('backend/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('backend/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/plugins/jquery-toastr/jquery.toast.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('backend/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('backend/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('backend/plugins/bootstrap-fileupload/bootstrap-fileupload.css') }}" rel="stylesheet" />
        <link href="{{ asset('backend/plugins/clockpicker/css/bootstrap-clockpicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('backend/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

        <!-- App css -->
        <link href="{{ asset('backend/vertical/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/vertical/assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/vertical/assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/vertical/assets/css/style.css') }}" rel="stylesheet" type="text/css" />

        <script src="{{ asset('backend/vertical/assets/js/modernizr.min.js') }}"></script>

    </head>


    <body>
    @yield('modal')
		<div class="modal fade" id="md_password" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popout" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white">Ganti Password</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('account.update', Auth::user()->id) }}" enctype="multipart/form-data" id="file-form">
                        @method('PUT')
                        @csrf
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="password_old" placeholder="Password Lama"
                                        autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="password_new" placeholder="Password Baru"
                                        autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check"></i> Ya
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">

                <div class="slimscroll-menu" id="remove-scroll">

                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a href="{{ route('home')}}" class="logo">
                            <span>
                                <img src="{{ asset('backend/assets/images/logo-mig.svg') }}" alt="" height="30" >
                            </span>
                            <i>
                                <img src="{{ asset('backend/assets/images/logo-mig.svg') }}" alt="" height="30" class="logo-large">
                            </i>
                        </a>
                    </div>

                    <!-- User box -->
                    <div class="user-box" align="center">
                        <div class="user-img">
                            <img src="@if (!empty(Auth::user()->photo)) {{  url('storage/'.Auth::user()->photo) }} @else {{ asset('backend/assets/images/users/avatar-2.jpg') }} @endif" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                        </div>
                        <h5><a href="#">{{ Auth::user()->name }}</a> </h5>
                        <p class="text-muted">{{ Auth::user()->position['name'] }}</p>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul class="metismenu" id="side-menu">

                            <!--<li class="menu-title">Navigation</li>-->
                            <li class="menu-title">Menu Utama</li>

                            <li>
                                <a href="{{ route('dashboard_okm.index') }}" class="{{ Request::url() == url('/okm/dashboard_okm') ? 'active' : '' }}">
                                    <i class="fi-air-play"></i> <span> Beranda </span>
                                </a>
                            </li>

							@if(Auth::user()->hasAnyPermission([1,24,27]))
                            <li>
                                <a href="{{ route('schedule.index') }}" class="{{ Request::url() == url('/okm/schedule') ? 'active' : '' }}">
                                    <i class="fa fa-calendar"></i> <span> Jadwal Ujian </>
                                </a>
                            </li>
							@endif

							@if(Auth::user()->hasAnyPermission([1,24,28]))
                            <li>
                                <a href="{{ route('raport.index') }}" class="{{ Request::url() == url('/okm/raport') ? 'active' : '' }}">
                                    <i class="fa fa-bar-chart"></i><span> Nilai Rapot </span>
                                </a>
                            </li>
							@endif

                            <li class="menu-title">Master Data</li>

							@if(Auth::user()->hasAnyPermission([1,24,29]))
                            <li>
                                <a href="{{ route('material.index') }}" class="{{ Request::url() == url('/okm/material') ? 'active' : '' }}">
                                    <i class="fa fa-book"></i> <span> Materi </span>
                                </a>
                            </li>
							@endif

                            @if(Auth::user()->hasAnyPermission([1,24,30]))
                            <li>
                                <a href="{{ route('question.index') }}" class="{{ Request::url() == url('/okm/question') ? 'active' : '' }}">
                                    <i class="fa fa-edit"></i> <span> Soal </span>
                                </a>
                            </li>
                            @endif

                        </ul>

                    </div>
                    <!-- Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                <!-- Top Bar Start -->
                <div class="topbar">

                    <nav class="navbar-custom">

                        <ul class="list-unstyled topbar-right-menu float-right mb-0">

                            <li class="dropdown notification-list" hidden>
                                <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <i class="fi-bell noti-icon"></i>
                                    <span class="badge badge-danger badge-pill noti-icon-badge" hidden>4</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg">


                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5 class="m-0"><span class="float-right"><a href="" class="text-dark"><small>Clear All</small></a> </span>Notification</h5>
                                    </div>

                                    <div class="slimscroll" style="max-height: 230px;">
                                    </div>

                                    <!-- All-->
                                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                        View all <i class="fi-arrow-right"></i>
                                    </a>

                                </div>
                            </li>

                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <img src="@if (!empty(Auth::user()->photo)) {{ url('storage/'.Auth::user()->photo) }} @else {{ asset('backend/assets/images/users/avatar-2.jpg') }} @endif" alt="user" class="rounded-circle"> <span class="ml-1">{{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i> </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                    <!-- item-->

                                    <!-- item-->
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#md_password" class="dropdown-item notify-item">
                                        <i class="fi-head"></i> <span>Ganti Password</span>
                                    </a>


                                    <!-- item-->
                                    <a href="{{ route('logout') }}" class="dropdown-item notify-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fi-power"></i> <span>Logout</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                </div>
                            </li>

                        </ul>

                        @yield('breadcrumb')

                    </nav>

                </div>
                <!-- Top Bar End -->



                <!-- Start Page content -->
                <div class="content">
                    @yield('content')

                </div> <!-- content -->

                <footer class="footer">
                    2019 © PT Molindo Inti Gas. - by. IT Team
                </footer>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->



        <!-- jQuery  -->
        <script src="{{ asset('backend/vertical/assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/vertical/assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('backend/vertical/assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('backend/vertical/assets/js/waves.js') }}"></script>
        <script src="{{ asset('backend/vertical/assets/js/jquery.slimscroll.js') }}"></script>

        <script src="{{ asset('backend/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('backend/plugins/bootstrap-select/js/bootstrap-select.js') }}" type="text/javascript"></script>
        <script src="{{ asset('backend/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
        <script src="{{ asset('backend/plugins/jquery-toastr/jquery.toast.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('backend/plugins/moment/moment.js') }}"></script>
        <script src="{{ asset('backend/plugins/bootstrap-timepicker/bootstrap-timepicker.js') }}"></script>
        <script src="{{ asset('backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/clockpicker/js/bootstrap-clockpicker.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('backend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
		<script src="{{ asset('backend/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backend/vertical/plugins/flot-chart/jquery.flot.pie.js') }}"></script>

        <!-- Init Js file -->
        <script type="text/javascript" src="{{ asset('backend/vertical/assets/pages/jquery.form-advanced.init.js') }}"></script>
        <script src="{{ asset('backend/plugins/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('backend/vertical/assets/pages/jquery.form-pickers.init.js') }}"></script>
		<script src="{{ asset('backend/assets/pages/jquery.flot.init.js') }}"></script>
        

        <!-- App js -->
        <script src="{{ asset('backend/vertical/assets/js/jquery.core.js') }}"></script>
        <script src="{{ asset('backend/vertical/assets/js/jquery.app.js') }}"></script>

        <script>
            $(function () {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajaxSetup({

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }

                });

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
        @yield('script')
    </body>
</html>