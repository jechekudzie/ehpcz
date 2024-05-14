<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none">

<head>
    <meta charset="utf-8"/>
    <title>EHPCZ - Administration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('administration/assets/images/favicon.ico')}}">
    <!-- Sweet Alert css-->
    <link href="{{asset('administration/assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <!-- Layout config Js -->
    <script src="{{asset('administration/assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('administration/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Font Awsome Icons Css V4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--  Icons Css  -->
    <link href="{{asset('administration/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{asset('administration/assets/css/app.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- custom Css-->
    <link href="{{asset('administration/assets/css/custom.min.css')}}" rel="stylesheet" type="text/css"/>

    @stack('head')
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
                        <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="" height="22">
                        </span>
                            <span class="logo-lg">
                            <img src="assets/images/logo-dark.png" alt="" height="17">
                        </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="" height="22">
                        </span>
                            <span class="logo-lg">
                            <img src="assets/images/logo-light.png" alt="" height="17">
                        </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    </button>
                </div>

                <div class="d-flex align-items-center">

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                data-toggle="fullscreen">
                            <i class='bx bx-fullscreen fs-22'></i>
                        </button>
                    </div>

                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <i class='bx bx-bell fs-22'></i>
                            <span
                                class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">3<span
                                    class="visually-hidden">unread messages</span></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                             aria-labelledby="page-header-notifications-dropdown">

                            <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                        </div>
                                        <div class="col-auto dropdown-tabs">
                                            <span class="badge badge-soft-light fs-13"> 1 New</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-2 pt-2">
                                    <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true"
                                        id="notificationItemsTab" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" href="#messages-tab"
                                               aria-selected="false">
                                                Messages
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="tab-content" id="notificationItemsTabContent">

                                <div class="tab-pane fade show active py-2 ps-2" id="messages-tab" role="tabpanel"
                                     aria-labelledby="messages-tab">
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">Sender</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">Brief tax.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 30 min ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="messages-notification-check01">
                                                        <label class="form-check-label"
                                                               for="messages-notification-check01"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="my-3 text-center">
                                            <button type="button" class="btn btn-soft-success waves-effect waves-light">
                                                View
                                                All Messages <i class="ri-arrow-right-line align-middle"></i></button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                      <span class="d-flex align-items-center">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                    @if(auth()->check())
                                        {{auth()->user()->name}}
                                    @endif
                                </span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                     @if(auth()->check())
                                        {{auth()->user()->roles->first()->name}}
                                    @endif
                                </span>
                            </span>
                        </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome Admin!</h6>
                            <a class="dropdown-item" href="pages-profile.html"><i
                                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Profile</span></a>
                            <a class="dropdown-item" href="apps-tasks-kanban.html"><i
                                    class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Taskboard</span></a>
                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="pages-profile-settings.html"><span
                                    class="badge bg-soft-success text-success mt-1 float-end">New</span><i
                                    class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Settings</span></a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item"href="{{route('logout')}}" onclick="event.preventDefault();
                                                this.closest('form').submit();"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">Logout</span></a>
                            </form>
                        </div>
                    </div>
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
                      <img src="{{asset('logo.png')}}" alt="" height="60">
                </span>
                <span class="logo-lg">
                     <img src="{{asset('logo.png')}}" alt="" height="60">
                </span>

                <span style="color: white;">EHPCZ</span>
            </a>
            <!-- Light Logo-->
            <a href="{{url('/')}}" class="logo logo-light">
                <span class="logo-sm">
                        <img src="{{asset('logo.png')}}" alt="" height="60">
                 </span>
                <span class="logo-lg">
                     <img src="{{asset('logo.png')}}" alt="" height="60">
                 </span>
                {{--<span style="color: white;">EHPCZ</span>--}}
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>
        <!-- LOGO -->
        <!-- SIDEBARD -->

        <!-- SIDEBARD -->

        <div class="sidebar-background"></div>
    </div>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div style="margin-top: -5%;" class="row">

                    @yield('content')

                </div>

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>{{date('Y')}}</script>
                        © EHPCZ.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by Leading Digital
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
<script src="{{asset('administration/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('administration/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('administration/assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('administration/assets/libs/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('administration/assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
<script src="{{asset('administration/assets/js/plugins.js')}}"></script>

<!-- list.js min js -->
<script src="{{asset('administration/assets/libs/list.js/list.min.js')}}"></script>
<script src="{{asset('administration/assets/libs/list.pagination.js/list.pagination.min.js')}}"></script>


{{--<script src="{{asset('administration/assets/js/pages/crm-companies.init.js')}}"></script>--}}
<!-- Jquery min js -->
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<!-- App js -->
<script src="{{asset('administration/assets/js/app.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var contactTypeDropdown = document.getElementById('contact_type_id');
        var countryDiv = document.querySelector('.country-code-div'); // Adjust this selector as needed
        var contactInput = document.getElementById('contact');

        function handleContactTypeChange() {
            // Get the selected option element
            var selectedOption = contactTypeDropdown.options[contactTypeDropdown.selectedIndex];
            // Get the name from the data-type-name attribute
            var selectedTypeName = selectedOption.getAttribute('data-type-name');


            // Check if the selected type name is 'Email'
            if (selectedTypeName === 'Email') {
                countryDiv.style.display = 'none'; // Hide country code div
                contactInput.placeholder = 'Enter your email'; // Change placeholder for email
                contactInput.value = '';
            } else {
                countryDiv.style.display = 'block'; // Show country code div
                contactInput.placeholder = 'eg. 0774685885'; // Default placeholder
                //clear contactInput
                contactInput.value = '';
            }
        }

        // Event listener for change on contact type dropdown
        contactTypeDropdown.addEventListener('change', handleContactTypeChange);

        // Initialize with the correct state
        handleContactTypeChange();
    });
</script>

<script>
    // Wait for the DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        // Set a timeout to hide the alerts after 10 seconds
        setTimeout(function() {
            var alertMessages = document.getElementsByClassName('alert-message');
            for(var i = 0; i < alertMessages.length; i++) {
                alertMessages[i].style.display = 'none';
            }
        }, 5000); // 5000 milliseconds = 5 seconds
    });
</script>

@stack('scripts')






</body>

</html>
