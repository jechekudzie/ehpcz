@extends('layouts.portal')

@push('head')
    <!-- datepicker css -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{asset('logo.png')}}" class="img-fluid mb-3" alt="EHPCZ Logo" />
                    <h1 style="padding-top: 3%;">EHPCZ Portal</h1>
                    <div>
                        <p class="lead">Dear Practitioners,</p>
                        <p>We appreciate your valuable suggestions and feedback. Our development team is actively
                            addressing the issues raised.</p>
                        <p>We are working diligently to update the system. We will advise you
                            by the end of this week once the updates are complete.</p>
                        <p>Thank you for your patience and understanding.</p>
                        <p>Best regards,</p>
                    </div>
                    <p><strong>Environmental Health Practitioners Council Of Zimbabwe</strong></p>
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
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{asset('administration/assets/js/pages/profile-setting.init.js')}}"></script>
    <!-- Ensure Date Picker -->
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
