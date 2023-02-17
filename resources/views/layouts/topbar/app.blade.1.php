<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title') | MIG - IS</title>

    <link rel="apple-touch-icon" href="{{ asset('backend/topbar/assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('backend/topbar/assets/images/favicon.ico') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/css/bootstrap-extend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/css/site.css') }}">

    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/animsition/animsition.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/switchery/switchery.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/intro-js/introjs.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/slidepanel/slidePanel.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/flag-icon-css/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/bootstrap-tokenfield/bootstrap-tokenfield.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/bootstrap-select/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/plyr/plyr.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/ladda/ladda.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/examples/css/uikit/buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/toastr/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/examples/css/advanced/toastr.css') }}">
    <!--link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/clockpicker/clockpicker.css') }}"-->
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/examples/css/forms/advanced.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/summernote/summernote.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/vendor/bootstrap-clockpicker/bootstrap-clockpicker.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/examples/css/structure/ribbon.css') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/fonts/font-awesome/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/fonts/web-icons/web-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/topbar/assets/fonts/brand-icons/brand-icons.min.css') }}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

    <!--[if lt IE 9]>
    <script src="backend/topbar/assets/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->

    <!--[if lt IE 10]>
    <script src="backend/topbar/assets/vendor/media-match/media.match.min.js"></script>
    <script src="backend/topbar/assets/vendor/respond/respond.min.js"></script>
    <![endif]-->

    <!-- Scripts -->
    <script src="{{ asset('backend/topbar/assets/vendor/breakpoints/breakpoints.js') }}"></script>
    <script>
        Breakpoints();

    </script>
</head>

<body class="animsition site-navbar-small site-menubar-hide">

    <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega navbar-inverse  @yield('color')" role="navigation">

        <div class="navbar-header">
            <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
                data-toggle="menubar">
                <span class="sr-only">Toggle navigation</span>
                <span class="hamburger-bar"></span>
            </button>
            <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse" data-toggle="collapse">
                <i class="icon wb-more-horizontal" aria-hidden="true"></i>
            </button>
            <a class="navbar-brand navbar-brand-center" href="../index.html">
                <img class="navbar-brand-logo navbar-brand-logo-special" src="{{ asset('backend/base/assets/images/logo-mig.svg') }}"
                    title="Remark" hidden>
                <span class="pt-5"> @yield('brand')</span>
            </a>
            <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search" data-toggle="collapse">
                <span class="sr-only">Toggle Search</span>
                <i class="icon wb-search" aria-hidden="true"></i>
            </button>
        </div>

        <div class="navbar-container container-fluid">
            <!-- Navbar Collapse -->
            <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
                <!-- Navbar Toolbar -->
                <ul class="nav navbar-toolbar">


                </ul>
                <!-- End Navbar Toolbar -->

                <!-- Navbar Toolbar Right -->
                <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">

                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" aria-expanded="false" data-animation="fade" role="button">Hi,
                            {{Auth::user()->name}}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                            data-animation="scale-up" role="button">
                            <span class="avatar avatar-online">
                                <img src="{{ asset(Auth::user()->photo) }}" alt="...">

                            </span>
                            <span hidden style="vertical-align: top;margin-top:10%">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-user"
                                    aria-hidden="true"></i> Profile</a>
                            <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-payment"
                                    aria-hidden="true"></i> Billing</a>
                            <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-settings"
                                    aria-hidden="true"></i> Settings</a>
                            <div class="dropdown-divider" role="presentation"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" role="menuitem"><i class="icon wb-power"
                                    aria-hidden="true" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                </i>Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" title="Notifications"
                            aria-expanded="false" data-animation="scale-up" role="button">
                            <i class="icon wb-bell" aria-hidden="true"></i>
                            <span class="badge badge-pill badge-danger up">5</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                            <div class="dropdown-menu-header">
                                <h5>NOTIFICATIONS</h5>
                                <span class="badge badge-round badge-danger">New 5</span>
                            </div>

                            <div class="list-group">
                                <div data-role="container">
                                    <div data-role="content">
                                        <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                            <div class="media">
                                                <div class="pr-10">
                                                    <i class="icon wb-order bg-red-600 white icon-circle" aria-hidden="true"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading">A new order has been placed</h6>
                                                    <time class="media-meta" datetime="2018-06-12T20:50:48+08:00">5
                                                        hours ago</time>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                            <div class="media">
                                                <div class="pr-10">
                                                    <i class="icon wb-user bg-green-600 white icon-circle" aria-hidden="true"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading">Completed the task</h6>
                                                    <time class="media-meta" datetime="2018-06-11T18:29:20+08:00">2
                                                        days ago</time>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                            <div class="media">
                                                <div class="pr-10">
                                                    <i class="icon wb-settings bg-red-600 white icon-circle"
                                                        aria-hidden="true"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading">Settings updated</h6>
                                                    <time class="media-meta" datetime="2018-06-11T14:05:00+08:00">2
                                                        days ago</time>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                            <div class="media">
                                                <div class="pr-10">
                                                    <i class="icon wb-calendar bg-blue-600 white icon-circle"
                                                        aria-hidden="true"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading">Event started</h6>
                                                    <time class="media-meta" datetime="2018-06-10T13:50:18+08:00">3
                                                        days ago</time>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                            <div class="media">
                                                <div class="pr-10">
                                                    <i class="icon wb-chat bg-orange-600 white icon-circle" aria-hidden="true"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading">Message received</h6>
                                                    <time class="media-meta" datetime="2018-06-10T12:34:48+08:00">3
                                                        days ago</time>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-menu-footer">
                                <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                                    <i class="icon wb-settings" aria-hidden="true"></i>
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                                    All notifications
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        @IF ( Route::currentRouteName() != 'home')
                        <a class="nav-link" href="{{ route('home') }}" title="Messages" aria-expanded="false"
                            data-animation="scale-up" role="button">
                            <i class="icon wb-grid-4" aria-hidden="true"></i>
                        </a>
                        @ENDIF
                    </li>
                </ul>
                <!-- End Navbar Toolbar Right -->
            </div>
            <!-- End Navbar Collapse -->
        </div>
    </nav>


    @yield('content')

    <!-- Footer -->
    <footer class="site-footer">
        <div class="site-footer-legal">© 2019 <a href="http://themeforest.net/item/remark-responsive-bootstrap-admin-template/11989202">PT
                MOLINDO INTI GAS</a></div>
        <div class="site-footer-right">
            Crafted with <i class="red-600 wb wb-heart"></i> by <a href="http://themeforest.net/user/amazingSurge">IT</a>
        </div>
    </footer>
    <!-- Core  -->
    <script src="{{ asset('backend/topbar/assets/vendor/babel-external-helpers/babel-external-helpers.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/popper-js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/bootstrap/bootstrap.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/animsition/animsition.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/asscrollbar/jquery-asScrollbar.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/asscrollable/jquery-asScrollable.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('backend/topbar/assets/vendor/switchery/switchery.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/intro-js/intro.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/screenfull/screenfull.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/slidepanel/jquery-slidePanel.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/plyr/plyr.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/matchheight/jquery.matchHeight-min.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/imagesloaded/imagesloaded.pkgd.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/masonry/masonry.pkgd.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/ladda/spin.min.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/toastr/toastr.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/timepicker/jquery.timepicker.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/bootstrap-clockpicker/bootstrap-clockpicker.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/multi-select/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/typeahead-js/bloodhound.min.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/typeahead-js/typeahead.jquery.min.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/vendor/summernote/summernote.js') }}"></script>

    <!-- Scripts -->
    <script src="{{ asset('backend/topbar/assets/js/Component.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Base.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Config.js') }}"></script>

    <script src="{{ asset('backend/topbar/assets/js/Section/Menubar.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Section/Sidebar.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Section/PageAside.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/menu.js') }}"></script>
    @yield('script')

    <!-- Config -->
    <script src="{{ asset('backend/topbar/assets/js/config/colors.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/config/tour.js') }}"></script>
    <script>
        Config.set('assets', 'backend/topbar/assets');

    </script>

    <!-- Page -->
    <script src="{{ asset('backend/topbar/assets/js/Site.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/asscrollable.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/slidepanel.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/switchery.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/select2.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/bootstrap-tokenfield.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/bootstrap-select.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/plyr.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/matchheight.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/masonry.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/loading-button.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/ladda.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/toastr.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/bootstrap-datepicker.js')}}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/clockpicker.js')}}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/summernote.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/examples/js/forms/editor-summernote.js') }}"></script>
    <script src="{{ asset('backend/topbar/assets/js/Plugin/input-group-file.js') }}"></script>

    <script>
        (function (document, window, $) {
            'use strict';

            var Site = window.Site;
            $(document).ready(function () {

                $(".assign_to").select2({
                    placeholder: "   Select user to assign this task"
                });

                $('.summernote').summernote({
                    placeholder: 'Hello bootstrap 4',
                    tabsize: 2,
                    height: 200
                });

                var postForm = function () {
                    var content = $('select[name="md_request_type"]').val();
                    return content;
                }

                /*$('select[name="md_request_type"]').on('change', function() {
                    alert($(this).val());
                });*/

                Site.run();

            });
        })(document, window, jQuery);

    </script>

</body>

</html>
