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
                        <h4 class="mb-sm-0" id="page-title">Add New Practitioner</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Add New Practitioner</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div style="margin-bottom: 3%;" class="row">
                    <div class="col-xxl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="flex-grow-1">

                                        <a href="{{route('practitioners.index')}}" class="btn btn-info btn-sm add-btn">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-xxl-12">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails"
                                           role="tab">
                                            <i class="fas fa-home"></i> Personal Details
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                        <div class="row">
                                            <!-- Form Column -->

                                            <form action="{{ route('practitioners.store') }}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <!-- Other Form Fields Column -->
                                                    <div class="col-lg-8">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label for="titleInput"
                                                                           class="form-label">Title</label>
                                                                    <select class="form-control" id="titleInput"
                                                                            name="title_id">
                                                                        <!-- Populate this with titles from your database -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label for="genderInput"
                                                                           class="form-label">Gender</label>
                                                                    <select class="form-control" id="genderInput"
                                                                            name="gender_id">
                                                                        <!-- Populate this with genders from your database -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label for="employmentStatusInput"
                                                                           class="form-label">Employment
                                                                        Status</label>
                                                                    <select class="form-control"
                                                                            id="employmentStatusInput"
                                                                            name="employment_status_id">
                                                                        <!-- Populate this with employment statuses from your database -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label for="firstnameInput" class="form-label">First
                                                                        Name</label>
                                                                    <input type="text" class="form-control"
                                                                           id="firstnameInput"
                                                                           name="first_name"
                                                                           placeholder="Enter your firstname">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label for="middlenameInput" class="form-label">Middle
                                                                        Name</label>
                                                                    <input type="text" class="form-control"
                                                                           id="middlenameInput"
                                                                           name="middle_name"
                                                                           placeholder="Enter your middle name">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label for="lastnameInput" class="form-label">Last
                                                                        Name</label>
                                                                    <input type="text" class="form-control"
                                                                           id="lastnameInput"
                                                                           name="last_name"
                                                                           placeholder="Enter your lastname">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="datepicker" class="form-label"
                                                                           id="dobLabel">Date of Birth</label>
                                                                    <input type="text" id="datepicker"
                                                                           class="form-control"
                                                                           name="dob" placeholder="Enter date of birth">
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="countryInput"
                                                                           class="form-label">Country</label>
                                                                    <select class="form-control" id="countryInput"
                                                                            name="country_id">
                                                                        <!-- Populate this with countries from your database -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- ... -->
                                                    </div>
                                                    <!-- Image Upload Column -->
                                                    <div style="margin-top: 5%" class="col-lg-4">
                                                        <div class="text-center">
                                                            <div
                                                                class="profile-user position-relative d-inline-block mx-auto mb-4">
                                                                <div
                                                                    class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                                    <input id="profile-img-file-input"
                                                                           type="file" name="profile_image"
                                                                           class="profile-img-file-input">
                                                                    <label for="profile-img-file-input"
                                                                           class="profile-photo-edit avatar-xs">
                                                                            <span style="font-size: 30px;"
                                                                                class="avatar-title rounded-circle bg-light text-body">
                                                                                <i class="ri-camera-fill"></i>
                                                                            </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <h5 class="fs-16 mb-1">Upload Practitioner Photo</h5>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-start">
                                                            <button type="submit" class="btn btn-primary">Submit
                                                            </button>
                                                            <button type="button" class="btn btn-soft-success">Cancel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

            </div>
            <!-- container-fluid -->
        </div>
    </div>
@stop
@push('scripts')

    <!-- profile-setting init js -->
    <script src="{{asset('administration/assets/js/pages/profile-setting.init.js')}}"></script>
    <!-- Ensure the path below is correct for your project -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $(function () {
            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd",
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
