@extends('layouts.admin')

@push('head')
    <!--datepicker css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush
@section('content')
    @livewireStyles
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
                       @livewire('practitioners.index', ['practitioners' => $practitioners])
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
    @livewireScripts
@endpush
