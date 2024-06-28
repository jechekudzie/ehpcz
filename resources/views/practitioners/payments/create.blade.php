@extends('layouts.admin_practitioner')
@push('head')
    <!--datepicker css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endpush
@section('title')
    Record Payment
@endsection
<!-- Include livewire styles -->
@livewireStyles

@section('content')
    <!--end col-->
    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            @include('partials.admin_practitioner.profile_nav')

            <div class="card-body p-4" style="font-weight: bold;color: black;!important;">
                <div class="tab-content">

                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                        <div class="card border card-border-primary">
                            <div class="card-header">
                            <span class="float-end fs-10">
                                 <a style="font-size: 12px; color: white;"
                                    href="{{route('renewal.payments.index',$renewal->id)}}"
                                    class="btn btn-success fw-medium">
                                     <i class="fa fa-arrow-left"></i> Back to {{$renewal->period}} Payments
                                 </a>
                                {{--<a style="font-size: 12px; color: white;" href="#" class="btn btn-primary fw-medium"
                                   data-bs-toggle="modal" data-bs-target="#addProfession">
                                    <i class="fa fa-plus"></i> Make Payment
                                </a>--}}
                            </span>
                                <h6 class="card-title mb-0">
                                    {{$renewal->practitioner->first_name. ' '. $renewal->practitioner->last_name}}
                                    - Record {{$renewal->period}} Payments
                                </h6><br/>
                                @livewire('payment.payments', ['renewal' => $renewal])

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end col-->
@endsection

<!-- Include livewire scripts -->
@livewireScripts
@push('scripts')
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
                    $('#payment_date').text('Payment Date (' + dateString + ')');
                }
            });
        });


    </script>
@endpush

