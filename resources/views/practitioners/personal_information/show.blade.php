@extends('layouts.admin_practitioner')
@push('head')
    <!--datepicker css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush
@section('content')
    <!--end col-->
    {{--@include('partials.admin_practitioner.profile')
--}}
    <div class="col-xxl-9" style="font-weight: bold;color:black!important;">
        <div class="card mt-xxl-n5">
            @include('partials.admin_practitioner.profile_nav')

            <div class="card-body p-4" style="font-weight: bold;color: black;!important;">
                <div class="tab-content">
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">

                        <div class="card border card-border-primary">
                            <div class="card-header">
                                                <span class="float-end align-middle fs-10">
                                                    <a style="color:white;"
                                                       href="{{route('practitioners.edit',$practitioner->slug)}}"
                                                       class="btn btn-primary fw-medium" data-bs-toggle="modal"
                                                       data-bs-target="#editPractitioner">
                                                        <i class="fa fa-pencil"></i> Edit
                                                    </a>
                                                </span>
                                <h6 class="card-title mb-0">Practitioner Details</h6><br/>
                                @if(session()->has('errors'))
                                    @php $errors = session('errors')->getBag('practitionerErrors') @endphp
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

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!--start col-->
                                    <div class="col-6 col-md-4">
                                        <div class="d-flex mt-4">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">First Name :</p>
                                                <h6 class="text-truncate mb-0">
                                                    {{$practitioner->first_name}}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!--start col-->
                                    <div class="col-6 col-md-4">
                                        <div class="d-flex mt-4">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Middle Name :</p>
                                                <h6 class="text-truncate mb-0">
                                                    {{$practitioner->middle_name}}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!--start col-->
                                    <div class="col-6 col-md-4">
                                        <div class="d-flex mt-4">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Last Name :</p>
                                                <h6 class="text-truncate mb-0">
                                                    {{$practitioner->last_name}}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <div class="d-flex mt-4">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Gender :</p>
                                                <h6 class="text-truncate mb-0">
                                                    @if($practitioner->gender)
                                                        {{$practitioner->gender->name}}
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!--start col-->
                                    <div class="col-6 col-md-4">
                                        <div class="d-flex mt-4">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Date of birth :</p>
                                                <h6 class="text-truncate mb-0">
                                                    @if($practitioner->dob == null)
                                                        Not Available
                                                    @else
                                                    {{ date('d F Y',strtotime($practitioner->dob)) }}
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!--start col-->
                                    <div class="col-6 col-md-4">
                                        <div class="d-flex mt-4">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Country of origin :</p>
                                                <h6 class="text-truncate mb-0">
                                                    @if($practitioner->country)
                                                        {{$practitioner->country->name}}
                                                    @endif

                                                </h6>

                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!--start col-->

                                    <!--end col-->
                                </div>

                                <div class="row">

                                    <div class="col-6 col-md-4">
                                        <div class="d-flex mt-4">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Identification :</p>
                                                <h6 class="text-truncate mb-0">
                                                    @if($practitioner->practitionerIdentifications)
                                                        {{$practitioner->practitionerIdentifications->first()->identification_number ?? 'Not Available'}}
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!--start col-->
                                    <div class="col-6 col-md-4">
                                        <div class="d-flex mt-4">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Employment Status :</p>
                                                <h6 class="text-truncate mb-0">
                                                    @if($practitioner->employmentStatus)
                                                        {{$practitioner->employmentStatus->name}}
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>

                            </div>
                        </div>

                        <div class="card border card-border-primary">
                            <div class="card-header">
                                 <span class="float-end align-middle fs-4">
                                    <a style="color:white;" href="#"
                                       class="btn btn-primary fw-medium" data-bs-toggle="modal"
                                       data-bs-target="#upload">
                                        <i class="fa fa-plus"></i> Upload
                                    </a>
                                </span>

                                <h6 class="card-title mb-0">Practitioner Identification</h6><br/>
                                @if(session()->has('errors'))
                                    @php $errors = session('errors')->getBag('identificationErrors')@endphp
                                    @if($errors->any())

                                        @foreach($errors->all() as $error)
                                            <!-- Success Alert -->
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong> Errors! </strong> {{ $error }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                            </div>
                                        @endforeach

                                    @endif
                                @endif
                                @if(session('identification_success'))
                                    <div class="col-8 alert alert-message alert-secondary alert-dismissible fade show"
                                         role="alert">
                                        <strong>Message!</strong> {{ session('identification_success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                @endif

                            </div>
                            <div class="card-body">
                                <div class="pt-3 mt-4">
                                    <div class="row g-3">
                                        <!-- start col -->
                                        @foreach($practitioner->practitionerIdentifications as $practitionerIdentification)
                                            <div class="col-xxl-6 col-lg-6">
                                                <div class="border rounded border-dashed p-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar-sm">
                                                                <div
                                                                    class="avatar-title bg-light text-secondary rounded fs-24">
                                                                    <i class="fa fa-file"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="fs-13 mb-1">
                                                                <a href="{{asset($practitionerIdentification->identification_file)}}"
                                                                   class="text-body text-truncate d-block"
                                                                   target="_blank">
                                                                    {{$practitionerIdentification->identificationType->name}}

                                                                    <!-- if identification_file is null -->

                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <div class="flex-shrink-0 ms-2">
                                                            <div class="d-flex gap-1">
                                                                @if($practitionerIdentification->identification_file == null)
                                                                    <span class="badge bg-danger m-3"> - Please Upload File </span>
                                                                @else
                                                                    <a href="{{asset($practitionerIdentification->identification_file)}}"
                                                                       class="btn btn-icon text-black btn-sm fs-18"
                                                                       target="_blank">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                                <div class="dropdown">
                                                                    <button
                                                                        class="btn btn-icon text-black btn-sm fs-18 dropdown"
                                                                        type="button"
                                                                        data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="ri-more-fill"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a class="dropdown-item edit-identification"
                                                                               href="#"
                                                                               data-id="{{ $practitionerIdentification->id }}"
                                                                               data-type-id="{{ $practitionerIdentification->identification_type_id }}"
                                                                               data-number="{{ $practitionerIdentification->identification_number }}"
                                                                               data-bs-toggle="modal"
                                                                               data-bs-target="#editDocument">
                                                                                <i class="fa fa-pencil align-bottom me-2 text-black"></i>
                                                                                Upload New
                                                                            </a>

                                                                        </li>
                                                                        <li><a class="dropdown-item"
                                                                               href="#"><i
                                                                                    class="fa fa-trash align-bottom me-2 text-black"></i>
                                                                                Delete</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- end col -->

                                    </div>
                                    <!-- end row -->
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editPractitioner" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Edit Personal Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form method="post"
                                              action="{{ route('practitioners.update', $practitioner->slug) }}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')

                                            <div class="row">
                                                <!-- Title Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="titleInput" class="form-label">Title</label>
                                                        <select class="form-control" id="titleInput" name="title_id">
                                                            <option value="">Select Title</option>
                                                            @foreach($titles as $title)
                                                                <option
                                                                    value="{{$title->id}}" {{ $practitioner->title_id == $title->id ? 'selected' : '' }}>{{$title->name}}</option>
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
                                                                    value="{{$gender->id}}" {{ $practitioner->gender_id == $gender->id ? 'selected' : '' }}>{{$gender->name}}</option>
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
                                                                    value="{{$employmentStatus->id}}" {{ $practitioner->employment_status_id == $employmentStatus->id ? 'selected' : '' }}>{{$employmentStatus->name}}</option>
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
                                                               name="first_name" placeholder="Enter your firstname"
                                                               value="{{ $practitioner->first_name }}">
                                                    </div>
                                                </div>

                                                <!-- Middle Name Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="middlenameInput" class="form-label">Middle
                                                            Name</label>
                                                        <input type="text" class="form-control" id="middlenameInput"
                                                               name="middle_name" placeholder="Enter your middle name"
                                                               value="{{ $practitioner->middle_name }}">
                                                    </div>
                                                </div>

                                                <!-- Last Name Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="lastnameInput" class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" id="lastnameInput"
                                                               name="last_name" placeholder="Enter your lastname"
                                                               value="{{ $practitioner->last_name }}">
                                                    </div>
                                                </div>

                                                <!-- Date of Birth Input -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="dobInput" id="dobLabel" class="form-label">Date of
                                                            Birth</label>
                                                        <input type="text" id="datepicker" class="form-control"
                                                               name="dob"
                                                               placeholder="Enter date of birth"
                                                               value="{{ $practitioner->dob }}">
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
                                                                    value="{{$country->id}}" {{ $practitioner->country_id == $country->id ? 'selected' : '' }}>{{$country->name}}</option>
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
                                                        <div style="margin-top: 3%;">
                                                            @if ($practitioner->image)
                                                                <img src="{{ asset($practitioner->image) }}"
                                                                     alt="Profile Image" style="width: 150px;">
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>

                                                <!-- Form Submission Buttons -->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-primary">Update
                                                            Practitioner
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel
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

                        <!-- Upload Document Modal -->
                        <div class="modal fade" id="upload" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Upload Identification</h5>
                                    </div>
                                    <!-- Warning Alert -->
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong> Please! </strong>Make sure the number matches the identification type
                                        you choose.!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post"
                                              action="{{ route('practitioner-identifications.store',$practitioner->slug) }}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <!-- Title Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="titleInput" class="form-label">Identification
                                                            Types</label>
                                                        <select class="form-control" id="titleInput"
                                                                name="identification_type_id">
                                                            <option value="">Select Identification Type</option>
                                                            @foreach($identificationTypes as $identificationType)
                                                                <option
                                                                    value="{{$identificationType->id}}">{{$identificationType->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- First Name Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="firstnameInput" class="form-label">ID or
                                                            Passport Or Birth Number</label>
                                                        <input type="text" class="form-control" id="firstnameInput"
                                                               name="identification_number"
                                                               placeholder="43173039Q47 or DN123456 or Birth Number">
                                                    </div>
                                                </div>

                                                <!-- Middle Name Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="identification_file" class="form-label">Upload
                                                            Document</label>
                                                        <input type="file" class="form-control" id="identification_file"
                                                               name="identification_file"
                                                               placeholder="">
                                                    </div>
                                                </div>

                                                <!-- Form Submission Buttons -->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">Close
                                                        </button>
                                                        <button type="submit" class="btn btn-success">Upload</button>
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

                        <!-- Edit Document Modal -->
                        <div class="modal fade" id="editDocument" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Upload Identification</h5>
                                    </div>
                                    <!-- Warning Alert -->
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong> Please! </strong>Make sure the number matches the identification type
                                        you choose.!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post"
                                              action=""
                                              enctype="multipart/form-data">
                                            @method('PATCH')
                                            @csrf
                                            <div class="row">
                                                <!-- Title Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="titleInput" class="form-label">Identification
                                                            Types</label>
                                                        <select class="form-control" id="identification_type_id"
                                                                name="identification_type_id">
                                                            <option value="">Select Identification Type</option>
                                                            @foreach($identificationTypes as $identificationType)
                                                                <option
                                                                    value="{{$identificationType->id}}">{{$identificationType->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- First Name Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="firstnameInput" class="form-label">Identification or
                                                            Passport Number</label>
                                                        <input type="text" class="form-control"
                                                               id="identification_number"
                                                               name="identification_number"
                                                               placeholder="43-173039Q47 /DN123456">
                                                    </div>
                                                </div>

                                                <!-- Middle Name Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="identification_file" class="form-label">Upload
                                                            Document</label>
                                                        <input type="file" class="form-control" id="identification_file"
                                                               name="identification_file"
                                                               placeholder="Upload the identification file">
                                                    </div>
                                                </div>

                                                <!-- Form Submission Buttons -->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">Close
                                                        </button>
                                                        <button type="submit" class="btn btn-success">Replace and
                                                            Update
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
@endsection

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
                yearRange: "1900:c", // Sets the start year to 1900 and the end year to the current year
                beforeShow: function (input, inst) {
                    setTimeout(function () {
                        inst.dpDiv.css({
                            top: $(input).offset().top - inst.dpDiv.outerHeight(),
                            left: $(input).offset().left
                        });
                    }, 0);
                },
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // When an edit link is clicked
            document.querySelectorAll('.edit-identification').forEach(function (element) {
                element.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    var typeId = this.getAttribute('data-type-id');
                    var number = this.getAttribute('data-number');

                    // alert(id + ' ' + typeId + ' ' + number);
                    // Update form action URL (assuming you have a route named 'practitioner-identifications.update')
                    // Select form elements and populate them
                    var modal = document.querySelector('#editDocument');
                    modal.querySelector('#identification_type_id').value = typeId;
                    modal.querySelector('#identification_number').value = number;
                    modal.querySelector('form').action = '/practitioner-identifications/' + id + '/update';
                });
            });
        });
    </script>

    <script>
        //get cities for city_id select based on province_id select using /api/cities/{province_id} route get method
        $(document).ready(function () {
            $('#province_id').on('change', function () {
                var province_id = this.value;
                $("#city_id").html('');
                $.ajax({
                    url: "{{url('api/cities')}}/" + province_id,
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        if (result.success) {
                            $('#city_id').html('<option value="">Select City</option>');
                            $.each(result.cities, function (key, value) {
                                $("#city_id").append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    }
                });
            });
        });


    </script>

@endpush

