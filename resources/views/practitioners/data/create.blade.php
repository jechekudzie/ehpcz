@extends('layouts.portal')

@push('head')
    <!--datepicker css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <h1> EHPCZ Portal </h1>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Error Messages -->
                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session()->has('errors'))
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Errors:</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                @endif

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">

                    <div class="col-lg-8 col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Instructions to new users</h4>

                                <p class="card-text">Apologies, If your account was not found, it, but you have an existing and valid
                                    registration number, submit your information, we can import your data for portal
                                    registration. </p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Practitioner Portal Account</h4>
                                <div class="modal-body">
                                    <form method="post" action="{{ route('portal.practitioner-data.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <!-- First Name Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="firstnameInput" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="firstnameInput" name="first_name" placeholder="Enter your firstname">
                                                </div>
                                            </div>

                                            <!-- Middle Name Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="middlenameInput" class="form-label">Middle Name</label>
                                                    <input type="text" class="form-control" id="middlenameInput" name="middle_name" placeholder="Enter your middle name">
                                                </div>
                                            </div>

                                            <!-- Last Name Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="lastnameInput" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" id="lastnameInput" name="last_name" placeholder="Enter your lastname">
                                                </div>
                                            </div>

                                            <!-- Identification Number Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="identificationNumberInput" class="form-label">Identification Number</label>
                                                    <input type="text" class="form-control" id="identificationNumberInput" name="identification_number" placeholder="Enter your identification number">
                                                </div>
                                            </div>

                                            <!-- Identification Type Dropdown -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="identificationTypeInput" class="form-label">Identification Type</label>
                                                    <select class="form-control" id="identificationTypeInput" name="identification_type_id">
                                                        <option value="">Select Identification Type</option>
                                                        @foreach($identificationTypes as $identificationType)
                                                            <option value="{{ $identificationType->id }}">{{ $identificationType->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Profession Dropdown -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="professionInput" class="form-label">Profession</label>
                                                    <select class="form-control" id="professionInput" name="profession_id">
                                                        <option value="">Select Profession</option>
                                                        @foreach($professions as $profession)
                                                            <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Qualification Dropdown -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="qualificationInput" class="form-label">Professional Qualification</label>
                                                    <select class="form-control" id="qualificationInput" name="qualification_id">
                                                        <option value="">Select Qualification</option>
                                                        @foreach($qualifications as $qualification)
                                                            <option value="{{ $qualification->id }}">{{ $qualification->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Registration Number Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="registrationNumberInput" class="form-label">Registration Number</label>
                                                    <input type="text" class="form-control" id="registrationNumberInput" name="registration_number" placeholder="Enter your registration number">
                                                </div>
                                            </div>

                                            <!-- Institution Dropdown -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="institutionInput" class="form-label">Institution</label>
                                                    <select class="form-control" id="institutionInput" name="institution_id">
                                                        <option value="">Select Institution</option>
                                                        @foreach($institutions as $institution)
                                                            <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Registration Year Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="registrationYearInput" class="form-label">Registration Year</label>
                                                    <input type="text" class="form-control" id="registrationYearInput" name="registration_year" placeholder="Enter your registration year">
                                                </div>
                                            </div>

                                            <!-- Employment Status Dropdown -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="employmentStatusInput" class="form-label">Employment Status</label>
                                                    <select class="form-control" id="employmentStatusInput" name="employment_status">
                                                        <option value="">Select Employment Status</option>
                                                        <option value="employed">Employed</option>
                                                        <option value="unemployed">Unemployed</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Current Employer Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="currentEmployerInput" class="form-label">Current Employer</label>
                                                    <input type="text" class="form-control" id="currentEmployerInput" name="current_employer" placeholder="Enter your current employer">
                                                </div>
                                            </div>

                                            <!-- Employment Sector Dropdown -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="employmentSectorInput" class="form-label">Employment Sector</label>
                                                    <select class="form-control" id="employmentSectorInput" name="employment_sector_id">
                                                        <option value="">Select Employment Sector</option>
                                                        @foreach($employmentSectors as $employmentSector)
                                                            <option value="{{ $employmentSector->id }}">{{ $employmentSector->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Province Dropdown -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="provinceInput" class="form-label">Province</label>
                                                    <select class="form-control" id="provinceInput" name="province_id">
                                                        <option value="">Select Province</option>
                                                        @foreach($provinces as $province)
                                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Email Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="emailInput" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="emailInput" name="email" placeholder="Enter your email">
                                                </div>
                                            </div>

                                            <!-- Address Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="addressInput" class="form-label">Address</label>
                                                    <input type="text" class="form-control" id="addressInput" name="address" placeholder="Enter your address">
                                                </div>
                                            </div>

                                            <!-- Phone Number Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="phoneNumberInput" class="form-label">Phone Number</label>
                                                    <input type="text" class="form-control" id="phoneNumberInput" name="phone_number" placeholder="Enter your phone number">
                                                </div>
                                            </div>

                                            <!-- Date of Birth Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="datepicker" class="form-label">Date of Birth</label>
                                                    <input type="text" class="form-control" id="datepicker" name="date_of_birth" placeholder="Enter date of birth">
                                                </div>
                                            </div>

                                            <!-- Gender Dropdown -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="genderInput" class="form-label">Gender</label>
                                                    <select class="form-control" id="genderInput" name="gender_id">
                                                        <option value="">Select Gender</option>
                                                        @foreach($genders as $gender)
                                                            <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <!-- Titles Dropdown -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="titleInput" class="form-label">Title</label>
                                                    <select class="form-control" id="titleInput" name="title_id">
                                                        <option value="">Select Title</option>
                                                        @foreach($titles as $title)
                                                            <option value="{{ $title->id }}">{{ $title->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Marital Status Dropdown -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="maritalStatusInput" class="form-label">Marital Status</label>
                                                    <select class="form-control" id="maritalStatusInput" name="marital_status_id">
                                                        <option value="">Select Marital Status</option>
                                                        @foreach($maritalStatuses as $maritalStatus)
                                                            <option value="{{ $maritalStatus->id }}">{{ $maritalStatus->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Form Submission Buttons -->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" onclick="window.location.href='{{ route('practitioners.index') }}'">Close</button>
                                                    <button type="submit" class="btn btn-success">Add New Practitioner</button>
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

        </div>
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
