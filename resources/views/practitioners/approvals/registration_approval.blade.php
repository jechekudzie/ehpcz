@extends('layouts.admin_practitioner')

@push('head')
    <!--datepicker css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@section('content')
    <div class="col-xxl-10">
        <div class="card mt-xxl-n5">
            @include('partials.admin_practitioner.profile_nav')

            <div class="card-body p-4" style="font-weight: bold; color: black; !important;">
                <div class="tab-content">
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                        <div class="card border card-border-primary">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Qualification Approvals</h6>
                            </div>
                            <div class="card-body">
                                @if($errors->any())
                                    @foreach($errors->all() as $error)
                                        <!-- Error Alert -->
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong> Errors! </strong> {{ $error }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endforeach
                                @endif

                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Message!</strong> {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                    @if(($role == 'accountant' || $role == 'accounts-clerk') && $qualification->status == 'pending')
                                        <form action="{{ route('qualifications.approve-by-accountant', $qualification->slug) }}" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Approval Status</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="approved">Approve</option>
                                                    <option value="disapproved">Disapprove</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="comments" class="form-label">Comments</label>
                                                <textarea class="form-control" id="comments" name="comments" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-success">Submit as Accountant/Accounts Clerk</button>
                                        </form>
                                    @endif


                                @if($role == 'admin' && ($qualification->status == 'pending' || $qualification->status == 'approved_by_accounts'))
                                    <form action="{{ route('qualifications.approve-by-admin', $qualification->slug) }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Approval Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="approved">Approve</option>
                                                <option value="disapproved">Disapprove</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="comments" class="form-label">Comments</label>
                                            <textarea class="form-control" id="comments" name="comments" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success">Submit as Admin</button>
                                    </form>
                                @endif



                                @if($role == 'registrar' && $qualification->status == 'approved_by_admin')
                                    <form action="{{ route('qualifications.approve-by-registrar', $qualification->slug) }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Approval Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="approved">Approve</option>
                                                <option value="disapproved">Disapprove</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="comments" class="form-label">Comments</label>
                                            <textarea class="form-control" id="comments" name="comments" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success">Submit as Registrar</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!--datepicker js-->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $(function () {
            $("#start_date").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });

            $("#end_date").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
        });

        // Fetch cities based on selected province
        $(document).ready(function () {
            $('#province_id').on('change', function () {
                var province_id = this.value;
                $("#city_id").html('');
                $.ajax({
                    url: "{{ url('api/cities') }}/" + province_id,
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
