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
    <!-- Icons Css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Font Awsome Icons Css V4 -->
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
                                            <span class="badge badge-soft-light fs-13"> 4 New</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-2 pt-2">
                                    <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true"
                                        id="notificationItemsTab" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-bs-toggle="tab" href="#messages-tab" role="tab"
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
                                                <img src="assets/images/users/avatar-3.jpg"
                                                     class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">James Lemire</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">We talked about a project on linkedin.</p>
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

                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <img src="assets/images/users/avatar-2.jpg"
                                                     class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">Angela Bernier</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">Answered to your comment on the cash flow
                                                            forecast's
                                                            graph 🔔.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 2 hrs ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="messages-notification-check02">
                                                        <label class="form-check-label"
                                                               for="messages-notification-check02"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <img src="assets/images/users/avatar-6.jpg"
                                                     class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">Kenneth Brown</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">Mentionned you in his comment on 📃 invoice
                                                            #12501.
                                                        </p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 10 hrs ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="messages-notification-check03">
                                                        <label class="form-check-label"
                                                               for="messages-notification-check03"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <img src="assets/images/users/avatar-8.jpg"
                                                     class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">Maureen Gibson</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">We talked about a project on linkedin.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 3 days ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="messages-notification-check04">
                                                        <label class="form-check-label"
                                                               for="messages-notification-check04"></label>
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
                            <a class="dropdown-item" href="apps-chat.html"><i
                                    class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Messages</span></a>
                            <a class="dropdown-item" href="apps-tasks-kanban.html"><i
                                    class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Taskboard</span></a>
                            <a class="dropdown-item" href="pages-faqs.html"><i
                                    class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Help</span></a>
                            <div class="dropdown-divider">

                            </div>

                            <a class="dropdown-item" href="pages-profile-settings.html"><span
                                    class="badge bg-soft-success text-success mt-1 float-end">New</span><i
                                    class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Settings</span></a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item"href="{{route('logout')}}" onclick="event.preventDefault();
                                                this.closest('form').submit();"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">Logout</span>
                                </a>
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
        <div id="scrollbar">
            <div class="container-fluid">

                <div id="two-column-menu">
                </div>
                <div id="two-column-menu">
                </div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li style="/*color:white;*/ font-size: 12px;" class="menu-title"><span data-key="t-menu">Practitioners Menu</span>
                    </li>

                    <!-- Contact Menu -->
                    <li class="nav-item">
                        <a style="/*color:white;*/ font-size: 12px;" class="nav-link menu-link collapsed"
                           href="#sidebarPractitioner" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarPractitioner">
                            <span data-key="t-dashboards">PRACTITIONER</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarPractitioner">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{route('practitioners.index')}}"
                                       class="nav-link" data-key="t-analytics" target="_blank">
                                        Practitioners
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{route('practitioners.index')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Reports
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <!-- end Contact Menu -->
                    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Pages</span></li>

                </ul>
                <ul class="navbar-nav" id="navbar-nav">
                    <li style="/*color:white;*/ font-size: 12px;" class="menu-title"><span
                            data-key="t-menu">Admin Menu</span></li>

                    <!-- Contact Menu -->
                    <li class="nav-item">
                        <a style="/*color:white;*/ font-size: 12px;" class="nav-link menu-link collapsed"
                           href="#sidebarContact" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarContact">
                            <span data-key="t-dashboards">CONTACT</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarContact">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{route('contact-types.index')}}"
                                       class="nav-link {{ Request::routeIs('contact-types.index*') ? 'active' : '' }}" data-key="t-analytics">
                                        Contact Type </a>
                                </li>
                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{route('address-types.index')}}"
                                       class="nav-link {{ Request::routeIs('address-types.index*') ? 'active' : '' }}"
                                       data-key="t-ecommerce"> Address Type </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <!-- end Contact Menu -->

                    <!-- Location Menu -->
                    <li class="nav-item">
                        <a style="/*color:white;*/ font-size: 12px;" class="nav-link menu-link collapsed"
                           href="#sidebarLocation" data-bs-toggle="collapse"
                           role="button"
                           aria-expanded="false" aria-controls="sidebarLocation">
                            <span data-key="t-dashboards">IMPORT PRACTITIONERS</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarLocation">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{route('import.practitioners')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Import Practitioners </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <!-- end Location Menu -->
                    <!-- Location Menu -->
                    <li class="nav-item">
                        <a style="/*color:white;*/ font-size: 12px;" class="nav-link menu-link collapsed"
                           href="#sidebarLocation" data-bs-toggle="collapse"
                           role="button"
                           aria-expanded="false" aria-controls="sidebarLocation">
                            <span data-key="t-dashboards">LOCATION</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarLocation">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/countries')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Countries </a>
                                </li>
                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/provinces')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Provinces </a>
                                </li>
                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/cities')}}" class="nav-link"
                                       data-key="t-ecommerce"> Cities </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <!-- end Location Menu -->

                    <!-- Identification Menu -->
                    <li class="nav-item">
                        <a style="/*color:white;*/ font-size: 12px;" class="nav-link menu-link collapsed"
                           href="#sidebarIdentification" data-bs-toggle="collapse"
                           role="button"
                           aria-expanded="false" aria-controls="sidebarIdentification">
                            <span data-key="t-dashboards">IDENTIFICATION TYPES</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarIdentification">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/titles')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Titles </a>
                                </li>
                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/genders')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Gender </a>
                                </li>
                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/identification-types')}}"
                                       class="nav-link"
                                       data-key="t-ecommerce"> Identification Document Types </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <!-- end Identification Menu -->

                    <!-- Requirements Menu -->
                    <li class="nav-item">
                        <a style="/*color:white;*/ font-size: 12px;" class="nav-link menu-link collapsed"
                           href="#sidebarRequirements" data-bs-toggle="collapse"
                           role="button"
                           aria-expanded="false" aria-controls="sidebarRequirements">
                            <span data-key="t-dashboards">REQUIREMENTS</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarRequirements">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/requirement-categories')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Requirement Categories </a>
                                </li>
                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/requirements')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Requirements </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <!-- end Requirements Menu -->

                    <!-- Professions Menu -->
                    <li class="nav-item">
                        <a style="/*color:white;*/ font-size: 12px;" class="nav-link menu-link collapsed"
                           href="#sidebarProfessions" data-bs-toggle="collapse"
                           role="button"
                           aria-expanded="false" aria-controls="sidebarProfessions">
                            <span data-key="t-dashboards">PROFESSIONS</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarProfessions">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/professions')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Professions </a>
                                </li>
                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/registers')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Registers </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <!-- end Professions Menu -->

                    <!-- Qualifications Menu -->
                    <li class="nav-item">
                        <a style="/*color:white;*/ font-size: 12px;" class="nav-link menu-link collapsed"
                           href="#sidebarQualifications" data-bs-toggle="collapse"
                           role="button"
                           aria-expanded="false" aria-controls="sidebarQualifications">
                            <span data-key="t-dashboards">QUALIFICATIONS</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarQualifications">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/qualification-categories')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Qualification Categories </a>
                                </li>
                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/qualifications')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Qualifications </a>
                                </li>

                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/qualification-level')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Qualification Levels </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- end Qualifications Menu -->

                    <!-- Institutions Menu -->
                    <li class="nav-item">
                        <a style="/*color:white;*/ font-size: 12px;" class="nav-link menu-link collapsed"
                           href="#sidebarInstitutions" data-bs-toggle="collapse"
                           role="button"
                           aria-expanded="false" aria-controls="sidebarInstitutions">
                            <span data-key="t-dashboards">ACCREDITATION</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarInstitutions">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/institutions')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Training Institutions </a>
                                </li>
                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{url('/accredited-institutions')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Accredited Qualifications </a>
                                </li>


                            </ul>
                        </div>
                    </li>
                    <!-- end Institutions Menu -->

                    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">ACCOUNT & FINANCE</span></li>
                    <!-- Institutions Menu -->
                    <li class="nav-item">
                        <a style="/*color:white;*/ font-size: 12px;" class="nav-link menu-link collapsed"
                           href="#FEES" data-bs-toggle="collapse"
                           role="button"
                           aria-expanded="false" aria-controls="FEES">
                            <span data-key="t-dashboards">ACCOUNT & FINANCE</span>
                        </a>
                        <div class="collapse menu-dropdown" id="FEES">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{route('fees-categories.index')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Payment Fees Categories </a>
                                </li>

                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{route('registration-rules.index')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Registration Rules </a>
                                </li>


                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{route('exchange-rate-types.index')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Exchange Rate Types </a>
                                </li>

                                <li class="nav-item">
                                    <a style="/*color:white;*/ font-size: 12px;" href="{{route('penalties.index')}}"
                                       class="nav-link" data-key="t-analytics">
                                        Penalty Settings </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <!-- end Institutions Menu -->

                </ul>
            </div>
            <!-- Sidebar -->
        </div>
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

        @yield('content')
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- App js -->
<script src="{{asset('administration/assets/js/app.js')}}"></script>

<script>
    $(document).ready(function () {
        // Iterate over each active nav-link
        $('.nav-link.active').each(function () {
            // Traverse up to find the parent 'menu-link'
            var parentMenuLink = $(this).closest('.collapse').prev('.menu-link');

            // Check if parentMenuLink is found
            if (parentMenuLink.length) {
                // Remove 'collapsed' class, set 'aria-expanded' to true, and add 'active' class
                parentMenuLink.removeClass('collapsed').addClass('active').attr('aria-expanded', 'true');

                // Expand the parent collapse menu
                $(this).closest('.collapse').addClass('show');
            }
        });
    });

</script>
@stack('scripts')


</body>

</html>
