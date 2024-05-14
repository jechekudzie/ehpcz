@extends('layouts.admin')

@push('head')
    <!--datepicker css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Health Practitioners</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                <li class="breadcrumb-item active">Health Practitioners</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-sm-4">
                            <div class="search-box">
                                <input type="text" class="form-control"
                                       placeholder="Search for name, tasks, projects or something...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-sm-auto ms-auto">
                            <div class="list-grid-nav hstack gap-1">

                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmembers"><i
                                        class="ri-add-fill me-1 align-bottom"></i> Add New Practitioner
                                </button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>

            <div class="row">
                @if(session()->has('errors'))
                    @if($errors->any())
                        <div class="row">
                            <div class="toast fade show col-8" role="alert" aria-live="assertive"
                                 data-bs-autohide="false" aria-atomic="true">
                                <div class="toast-header">
                                    <span class="fw-semibold me-auto">Validation Errors</span>
                                    <small>Just now</small>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast"
                                            aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                @if(session('success'))
                    <div class="col-8 alert alert-message alert-secondary alert-dismissible fade show"
                         role="alert">
                        <strong>Message!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                    </div>
                @endif
                <div class="col-lg-12">
                    <div>
                        <div class="team-list grid-view-filter row">
                            @foreach($practitioners as $practitioner)
                                <!--start practitioner col-->
                                <div class="col-md-3">
                                    <div class="card team-box">
                                        <div class="team-cover">
                                            <img
                                                src="https://placehold.co/800x533/405189/FFFFFF?text={{$practitioner->first_name.'+'.$practitioner->last_name}}"
                                                alt="" class="img-fluid"/>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row align-items-center team-row">
                                                <div class="col team-settings">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="bookmark-icon flex-shrink-0 me-2"></div>
                                                        </div>
                                                        <div class="col text-end dropdown">
                                                            <a href="javascript:void(0);" id="dropdownMenuLink3"
                                                               data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-fill fs-17"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="dropdownMenuLink3">
                                                                <li><a class="dropdown-item" href="javascript:void(0);">Renewal
                                                                        Status</a>
                                                                </li>
                                                                <li><a class="dropdown-item" href="javascript:void(0);">Payments</a>
                                                                </li>
                                                                <li><a class="dropdown-item" href="javascript:void(0);">Certificates</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4 col">
                                                    <div class="team-profile-img">
                                                        <div
                                                            class="avatar-lg img-thumbnail rounded-circle flex-shrink-0">

                                                            @if($practitioner->image)
                                                                <div
                                                                    class="avatar-lg img-thumbnail rounded-circle flex-shrink-0">
                                                                    <img src="{{ asset($practitioner->image) }}" alt=""
                                                                         class="img-fluid d-block rounded-circle"/>
                                                                </div>
                                                            @else
                                                                @php
                                                                    $initials = '';
                                                                    if ($practitioner->first_name) {
                                                                        $initials .= strtoupper($practitioner->first_name[0]);
                                                                    }
                                                                    if ($practitioner->last_name) {
                                                                        $initials .= strtoupper($practitioner->last_name[0]);
                                                                    }
                                                                @endphp
                                                                <div
                                                                    class="avatar-title bg-soft-danger text-danger rounded-circle">
                                                                    {{ $initials }}
                                                                </div>
                                                            @endif


                                                        </div>
                                                        <div class="team-content">
                                                            <a data-bs-toggle="offcanvas" href="#offcanvasExample"
                                                               aria-controls="offcanvasExample">
                                                                <h5 class="fs-16 mb-1">{{ $practitioner->first_name.' '.$practitioner->last_name }}</h5>
                                                            </a>
                                                            <p class="text-muted mb-0">
                                                                @if($practitioner->practitionerProfessions)
                                                                    <!-- Display the first profession -->
                                                                    @foreach($practitioner->practitionerProfessions as $profession)
                                                                        {{ $profession->profession->name }}
                                                                        @break
                                                                    @endforeach

                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-2 col">
                                                    <div class="text-end">
                                                        <a href="{{route('practitioners.show',$practitioner->slug)}}"
                                                           class="btn btn-light view-btn">View
                                                            Profile</a>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </div>
                                    </div>
                                    <!--end card-->
                                </div>
                                <!--end practitioner col-->
                            @endforeach

                        </div>
                        <!--end row-->

                        <!-- Modal -->
                        <div class="modal fade" id="addmembers" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Add New Practitioner</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{ route('practitioners.store') }}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <!-- Title Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="titleInput" class="form-label">Title</label>
                                                        <select class="form-control" id="titleInput" name="title_id">
                                                            <option value="">Select Title</option>
                                                            @foreach($titles as $title)
                                                                <option value="{{$title->id}}">{{$title->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Gender Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="genderInput" class="form-label">Gender</label>
                                                        <select class="form-control" id="genderInput" name="gender_id">
                                                            <option value="">Select Gender</option>
                                                            @foreach($genders as $gender)
                                                                <option
                                                                    value="{{$gender->id}}">{{$gender->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Employment Status Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="employmentStatusInput" class="form-label">Employment
                                                            Status</label>
                                                        <select class="form-control" id="employmentStatusInput"
                                                                name="employment_status_id">
                                                            <option value="">Select Employment Status</option>
                                                            @foreach($employmentStatuses as $employmentStatus)
                                                                <option
                                                                    value="{{$employmentStatus->id}}">{{$employmentStatus->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- First Name Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="firstnameInput" class="form-label">First
                                                            Name</label>
                                                        <input type="text" class="form-control" id="firstnameInput"
                                                               name="first_name" placeholder="Enter your firstname">
                                                    </div>
                                                </div>

                                                <!-- Middle Name Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="middlenameInput" class="form-label">Middle
                                                            Name</label>
                                                        <input type="text" class="form-control" id="middlenameInput"
                                                               name="middle_name" placeholder="Enter your middle name">
                                                    </div>
                                                </div>

                                                <!-- Last Name Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="lastnameInput" class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" id="lastnameInput"
                                                               name="last_name" placeholder="Enter your lastname">
                                                    </div>
                                                </div>

                                                <!-- Date of Birth Input -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="datepicker" class="form-label" id="dobLabel">Date of
                                                            Birth</label>
                                                        <input type="text" id="datepicker" class="form-control"
                                                               name="dob" placeholder="Enter date of birth">
                                                    </div>
                                                </div>

                                                <!-- Country of Origin Dropdown -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="countryInput" class="form-label">Country of
                                                            Origin</label>
                                                        <select class="form-control" id="countryInput"
                                                                name="country_id">
                                                            <option value="">Select Country of Origin</option>
                                                            @foreach($countries as $country)
                                                                <option
                                                                    value="{{$country->id}}">{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Profile Image Upload -->
                                                <div class="col-lg-12">
                                                    <div class="mb-4">
                                                        <label for="formFile" class="form-label">Profile Image</label>
                                                        <input class="form-control" type="file" name="image"
                                                               id="formFile">
                                                    </div>
                                                </div>

                                                <!-- Form Submission Buttons -->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">Close
                                                        </button>
                                                        <button type="submit" class="btn btn-success">Add New
                                                            Practitioner
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                <!--end modal-content-->
                            </div>
                            <!--end modal-dialog-->
                        </div>
                        <!--end modal-->

                        <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="offcanvasExample">
                            <!--end offcanvas-header-->
                            <div class="offcanvas-body profile-offcanvas p-0">
                                <div class="team-cover">
                                    <img src="assets/images/small/img-9.jpg" alt="" class="img-fluid"/>
                                </div>
                                <div class="p-3">
                                    <div class="team-settings">
                                        <div class="row">
                                            <div class="col">
                                                <div class="bookmark-icon flex-shrink-0 me-2">
                                                    <input type="checkbox" id="favourite13"
                                                           class="bookmark-input bookmark-hide">
                                                    <label for="favourite13" class="btn-star">
                                                        <svg width="20" height="20">
                                                            <use xlink:href="#icon-star"/>
                                                        </svg>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col text-end dropdown">
                                                <a href="javascript:void(0);" id="dropdownMenuLink14"
                                                   data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill fs-17"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="dropdownMenuLink14">
                                                    <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-eye-line me-2 align-middle"></i>View</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-star-line me-2 align-middle"></i>Favorites</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-delete-bin-5-line me-2 align-middle"></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <div class="p-3 text-center">
                                    <img src="assets/images/users/avatar-2.jpg" alt=""
                                         class="avatar-lg img-thumbnail rounded-circle mx-auto">
                                    <div class="mt-3">
                                        <h5 class="fs-15"><a href="javascript:void(0);" class="link-primary">Nancy
                                                Martino</a></h5>
                                        <p class="text-muted">Health Practitioners Leader & HR</p>
                                    </div>
                                    <div class="hstack gap-2 justify-content-center mt-4">
                                        <div class="avatar-xs">
                                            <a href="javascript:void(0);"
                                               class="avatar-title bg-soft-secondary text-secondary rounded fs-16">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </div>
                                        <div class="avatar-xs">
                                            <a href="javascript:void(0);"
                                               class="avatar-title bg-soft-success text-success rounded fs-16">
                                                <i class="ri-slack-fill"></i>
                                            </a>
                                        </div>
                                        <div class="avatar-xs">
                                            <a href="javascript:void(0);"
                                               class="avatar-title bg-soft-info text-info rounded fs-16">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </div>
                                        <div class="avatar-xs">
                                            <a href="javascript:void(0);"
                                               class="avatar-title bg-soft-danger text-danger rounded fs-16">
                                                <i class="ri-dribbble-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-0 text-center">
                                    <div class="col-6">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1">124</h5>
                                            <p class="text-muted mb-0">Projects</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-6">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1">81</h5>
                                            <p class="text-muted mb-0">Tasks</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <div class="p-3">
                                    <h5 class="fs-15 mb-3">Personal Details</h5>
                                    <div class="mb-3">
                                        <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">Number</p>
                                        <h6>+(256) 2451 8974</h6>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">Email</p>
                                        <h6>nancymartino@email.com</h6>
                                    </div>
                                    <div>
                                        <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">Location</p>
                                        <h6 class="mb-0">Carson City - USA</h6>
                                    </div>
                                </div>
                                <div class="p-3 border-top">
                                    <h5 class="fs-15 mb-4">File Manager</h5>
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title bg-soft-danger text-danger rounded fs-16">
                                                <i class="ri-image-2-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"><a href="javascript:void(0);">Images</a></h6>
                                            <p class="text-muted mb-0">4469 Files</p>
                                        </div>
                                        <div class="text-muted">
                                            12 GB
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title bg-soft-secondary text-secondary rounded fs-16">
                                                <i class="ri-file-zip-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"><a href="javascript:void(0);">Documents</a></h6>
                                            <p class="text-muted mb-0">46 Files</p>
                                        </div>
                                        <div class="text-muted">
                                            3.46 GB
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title bg-soft-success text-success rounded fs-16">
                                                <i class="ri-live-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"><a href="javascript:void(0);">Media</a></h6>
                                            <p class="text-muted mb-0">124 Files</p>
                                        </div>
                                        <div class="text-muted">
                                            4.3 GB
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title bg-soft-primary text-primary rounded fs-16">
                                                <i class="ri-error-warning-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"><a href="javascript:void(0);">Others</a></h6>
                                            <p class="text-muted mb-0">18 Files</p>
                                        </div>
                                        <div class="text-muted">
                                            846 MB
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end offcanvas-body-->
                            <div class="offcanvas-foorter border p-3 hstack gap-3 text-center position-relative">
                                <button class="btn btn-light w-100"><i
                                        class="ri-question-answer-fill align-bottom ms-1"></i> Send Message
                                </button>
                                <a href="pages-profile.html" class="btn btn-primary w-100"><i
                                        class="ri-user-3-fill align-bottom ms-1"></i> View Profile</a>
                            </div>
                        </div>
                        <!--end offcanvas-->
                    </div>
                </div><!-- end col -->
            </div>
            <!--end row-->

            <svg class="bookmark-hide">
                <symbol viewBox="0 0 24 24" stroke="currentColor" fill="var(--color-svg)" id="icon-star">
                    <path stroke-width=".4"
                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </symbol>
            </svg>

        </div><!-- container-fluid -->
    </div>
@stop
@push('scripts')

    <script src="{{asset('administration/assets/js/pages/profile-setting.init.js')}}"></script>
    <!-- Ensure Date Picker-->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $(function () {
            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                onSelect: function (dateText, inst) {
                    var date = $(this).datepicker('getDate'),
                        day = date.getDate(),
                        month = date.getMonth() + 1,
                        year = date.getFullYear();

                    var monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"];

                    var dateString = day + ' ' + monthNames[month - 1] + ' ' + year;
                    $('#dobLabel').text('Date of Birth (' + dateString + ')');
                }
            });
        });
    </script>

@endpush
