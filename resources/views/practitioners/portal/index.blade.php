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
                    <div style="font-size: 15px;" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Message!</strong> {!! session('error') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                @if(session()->has('errors'))
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Message:</strong>
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

                                <p class="card-text">If you are accessing the portal for the first time, please use your
                                    registration number and identification details to create your account.</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Practitioner Portal Account</h4>
                                <div class="modal-body">
                                    <form method="post" action="{{ route('portal.checkExistence') }}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <!-- Registration Number Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="registration_number" class="form-label">Registration
                                                        Number</label>
                                                    <input type="text" class="form-control" id="registration_number"
                                                           name="registration_number" required
                                                           placeholder="Enter your Registration Number">
                                                </div>
                                            </div>

                                            <!-- Identification Type Selection -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="identification_type_id" class="form-label">Choose
                                                        Identification type</label>
                                                    <select class="form-control" id="identification_type_id"
                                                            name="identification_type_id" required>
                                                        <option value="">Select Identification Type</option>
                                                        @foreach(\App\Models\IdentificationType::whereNotIn('id',[3])->get() as $identificationType)
                                                            <option
                                                                value="{{$identificationType->id}}">{{$identificationType->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Identification Number Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="identification_number" class="form-label">ID
                                                        Number</label>
                                                    <input type="text" class="form-control" id="identification_number"
                                                           name="identification_number"
                                                           {{--value="61-059678P61"--}} required
                                                           placeholder="Enter your Identification or Passport Number">
                                                </div>
                                            </div>

                                            <!-- Email Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email Address</label>
                                                    <input type="text" class="form-control" id="email"
                                                           name="email" required
                                                           placeholder="Enter your Email Address">
                                                </div>
                                            </div>

                                            <!-- Phone Number Input -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Primary Mobile Number</label>
                                                    <input type="number" class="form-control" id="phone"
                                                           name="phone" required
                                                           placeholder="Enter your Primary Phone Number eg. 263774685884">
                                                </div>
                                            </div>

                                            <!-- Form Submission Button -->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-start">
                                                    <button type="submit" class="btn btn-success">
                                                        Check Registration Number Existence
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mt-5">
                                                <p class="card-text">If you already have login credentials, please enter your email
                                                    address and password to access the EHPCZ Portal.</p>
                                                <div class="hstack gap-2 justify-content-start">
                                                    <a href="{{ url('/login') }}" class="btn btn-secondary">Login</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                       {{--   <div class="col-lg-4 col-md-4">
                              <div class="card">
                                  <div class="card-body">
                                      <h4 class="card-title">Instructions Existing Users</h4>

                                      <p class="card-text">If you already have login credentials, please enter your email
                                          address and password to access the EHPCZ Portal.</p>
                                  </div>
                              </div>

                              <div class="card mt-4">
                                  <div class="card-body">
                                      <h4 class="card-title">Login</h4>
                                      <form method="post" action="{{ route('portal.login') }}">
                                          @csrf
                                          <div class="mb-3">
                                              <label for="email" class="form-label">Email Address</label>
                                              <input type="email" class="form-control" id="email" name="email" required
                                                     placeholder="Enter your Email">
                                          </div>

                                          <div class="mb-3">
                                              <label for="password" class="form-label">Password</label>
                                              <input type="password" class="form-control" id="password" name="password"
                                                     required
                                                     placeholder="Enter your Password">
                                          </div>

                                          <div class="mb-3 form-check">
                                              <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                              <label class="form-check-label" for="remember">Remember Me</label>

                                          </div>

                                          <div class="mb-3 form-check">
                                              @if (Route::has('password.request'))
                                                  <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                                      {{ __('Forgot your password?') }}
                                                  </a>
                                              @endif
                                          </div>

                                          <button type="submit" class="btn btn-primary">Login</button>
                                      </form>

                                      <hr>

                                      <p class="card-text">If you are accessing the portal for the first time, please use your
                                          registration number and identification details to create your account.</p>
                                  </div>
                              </div>
                          </div>--}}
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
