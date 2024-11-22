<!doctype html>
<html lang="en" data-layout="horizontal" data-layout-style="" data-layout-position="fixed" data-topbar="light">

<head>
    <meta charset="utf-8"/>
    <title>EHPCZ - ELECTIONS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('administration/assets/images/favicon.ico') }}">

    <!-- Plugin CSS -->
    <link href="{{ asset('administration/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet"
          type="text/css"/>

    <!-- Layout config JS -->
    <script src="{{ asset('administration/assets/js/layout.js') }}"></script>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('administration/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Icons CSS -->
    <link href="{{ asset('administration/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- App CSS -->
    <link href="{{ asset('administration/assets/css/app.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Custom CSS -->
    <link href="{{ asset('administration/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Icons Css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @stack('styles')
    @livewireStyles


</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <a href="{{url('/')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{asset('logo.png')}}" alt="" height="70">
                        </span>
                            <span class="logo-lg">
                            <img src="{{asset('logo.png')}}" alt="" height="70">
                        </span>
                        </a>

                        <a href="{{url('/')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{asset('logo.png')}}" alt="" height="70">
                        </span>
                            <span class="logo-lg">
                            <img src="{{asset('logo.png')}}" alt="" height="70">
                        </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon"
                            style="background-color: #405189; color: white; border: 1px solid black;">
                        <span class="hamburger-icon">
                            <span style="background-color: white; display: block; height: 2px; margin: 4px 0;"></span>
                            <span style="background-color: white; display: block; height: 2px; margin: 4px 0;"></span>
                            <span style="background-color: white; display: block; height: 2px; margin: 4px 0;"></span>
                        </span>
                    </button>

                </div>


            </div>
        </div>
    </header>

    <!-- ========== App Menu ========== -->
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="{{url('/')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('logo.png')}}" alt="" height="22">
                    </span>
                <span class="logo-lg">
                        <img src="{{asset('logo.png')}}" alt="" height="17">
                    </span>
            </a>
            <!-- Light Logo-->
            <a href="{{url('/')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('logo.png')}}" alt="" height="22">
                    </span>
                <span class="logo-lg">
                        <img src="{{asset('logo.png')}}" alt="" height="17">
                    </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>

        <div id="scrollbar">
            <div class="container-fluid">

                <div id="two-column-menu">

                </div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{url('/voting')}}"
                           {{--data-bs-toggle="collapse"--}} role="button" aria-expanded="false"
                           aria-controls="sidebarDashboards">
                            <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Elections Home</span>
                        </a>
                    </li> <!-- end Dashboard Menu -->


                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route('voting.voters-roll')}}"
                           {{--data-bs-toggle="collapse"--}} role="button" aria-expanded="false"
                           aria-controls="sidebarLayouts">
                            <i class="fa fa-users"></i> <span data-key="t-layouts">Voters Roll</span>
                        </a>

                    </li> <!-- end Dashboard Menu -->
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{url('/voting/results')}}"
                           {{--data-bs-toggle="collapse"--}} role="button" aria-expanded="false"
                           aria-controls="sidebarLayouts">
                            <i class="fa fa-pie-chart"></i> <span data-key="t-layouts">Results</span>
                        </a>

                    </li> <!-- end Dashboard Menu -->

                    @if(auth()->check())
                        @hasanyrole('admin|registrar|super-admin')
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{url('/elections')}}"
                               {{--data-bs-toggle="collapse"--}} role="button" aria-expanded="false"
                               aria-controls="sidebarLayouts">
                                <i class="fa fa-archive"></i> <span data-key="t-layouts">Manage Elections</span>
                            </a>

                        </li> <!-- end Dashboard Menu -->

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button"
                               aria-expanded="false" aria-controls="sidebarLayouts">
                                <i class="fa fa-user-plus"></i> <span data-key="t-layouts">Super Admin</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarLayouts">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="" target="_blank" class="nav-link" data-key="t-horizontal">System
                                            Modules</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" target="_blank" class="nav-link" data-key="t-detached">Roles &
                                            Permissions</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" target="_blank" class="nav-link" data-key="t-detached">System
                                            Users</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" target="_blank" class="nav-link" data-key="t-detached">Signature
                                            Configurations</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endhasanyrole
                    @endif

                </ul>
            </div>
            <!-- Sidebar -->
        </div>

        <div class="sidebar-background"></div>


    </div>
    <!-- Left Sidebar End -->

    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <!-- Start Page-content -->
        @yield('content')
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        {{ date('Y') }}
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Developed By Leading Digital
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->


<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!-- JAVASCRIPT -->
<script src="{{ asset('administration/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('administration/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('administration/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('administration/assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('administration/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('administration/assets/js/plugins.js') }}"></script>

<!-- ApexCharts -->
<script src="{{ asset('administration/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Vector map -->
<script src="{{ asset('administration/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('administration/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

<!-- Dashboard init -->
<script src="{{ asset('administration/assets/js/pages/dashboard-analytics.init.js') }}"></script>

<!-- App JS -->
<script src="{{ asset('administration/assets/js/app.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    flatpickr(".election_date", {
        enableTime: false,
        dateFormat: "Y-m-d",
        // dateFormat: "Y-m-d H:i",
        //date on top
        position: "above",
    });
</script>

@stack('scripts')
@livewireScripts

</body>

</html>
