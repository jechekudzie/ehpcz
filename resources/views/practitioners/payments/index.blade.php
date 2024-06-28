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
@section('content')
    <!--end col-->
    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            @include('partials.admin_practitioner.profile_nav')

            <div class="card-body p-4" style="font-weight: bold;color: black;!important;">
                <div class="tab-content">
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
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                        <div class="card border card-border-primary">
                            <div class="card-header">
                            <span class="float-end fs-10">
                                 <a style="font-size: 12px; color: white;"
                                    href="{{route('renewals.index',$renewal->practitioner->slug)}}"
                                    class="btn btn-success fw-medium">
                                     <i class="fa fa-arrow-left"></i> Back To Renewals
                                 </a>
                                {{--<a style="font-size: 12px; color: white;" href="#" class="btn btn-primary fw-medium"
                                   data-bs-toggle="modal" data-bs-target="#addProfession">
                                    <i class="fa fa-plus"></i> Make Payment
                                </a>--}}

                                <a style="font-size: 12px; color: white;"
                                   href="{{route('renewal.payments.create',$renewal->id)}}"
                                   class="btn btn-primary fw-medium">
                                    <i class="fa fa-plus"></i> Record {{ $renewal->period }} Payment
                                </a>


                            </span>
                                <h6 class="card-title mb-0">{{$renewal->practitioner->first_name. ' '. $renewal->practitioner->last_name}}
                                    -
                                    Record {{$renewal->period}} Payments
                                </h6><br/>
                                <table style="width: 100%;" id="buttons-datatables"
                                       class="display table table-bordered dataTable no-footer"
                                       aria-describedby="buttons-datatables_info">
                                    <thead>
                                    <tr>
                                        <th>Period</th>
                                        <th>Fee Category</th>
                                        <th>Fee</th>
                                        <th>Amount Invoiced</th>
                                        <th>Amount Paid</th>
                                        <th>Balance</th>
                                        <th>Currency</th>
                                        <th>Exchange Rate</th>
                                        <th>Exchange Rate Type</th>
                                        <th>Approval</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($renewal->payments as $payment)
                                        <tr class="even">
                                            <td style="font-weight: normal;">{{$renewal->period}}</td>
                                            <td style="font-weight: normal;">{{$payment->feeCategory->name}}</td>
                                            <td style="font-weight: normal;">{{$payment->feeItem->name}}</td>
                                            <td style="font-weight: normal;">{{$payment->amount_invoiced}}</td>
                                            <td style="font-weight: normal;">{{$payment->amount_paid}}</td>
                                            <td style="font-weight: normal;">{{$payment->balance}}</td>
                                            <td style="font-weight: normal;">{{$payment->currency->name}}</td>
                                            <td style="font-weight: normal;">{{$payment->exchange_rate}}</td>
                                            <td style="font-weight: normal;">
                                                @if($payment->exchangeRate)
                                                {{$payment->exchangeRate->exchangeRateType->name}}
                                                @endif
                                            </td>

                                            <td style="font-weight: normal;">
                                                <a href="{{route('check-for-payment-approval',$payment->id)}}" class="btn btn-sm btn-block btn-outline-primary d-flex justify-content-between align-items-center" title="Edit">
                                                    <div style="text-align: center;">
                                                        <i class="fa fa-check text-success"></i> or <i class="fa fa-times text-danger"></i>
                                                    </div>
                                                </a>
                                            </td>

                                            <td style="font-weight: normal;">

                                                <!-- Edit Button -->
                                                <a href=""
                                                   class="edit-button btn btn-sm btn-primary" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <!-- Delete Button -->
                                                <form action="" method="POST"
                                                      onsubmit="return confirm('Are you sure?');"
                                                      style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Add Modal -->
                    <div class="modal fade" id="addProfession" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Record {{$renewal->period}} Payments</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{ route('renewal.payments.store', $renewal->id) }}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- Payment Method Dropdown -->
                                                <div class="mb-3">
                                                    <label for="payment_method_id" class="form-label">Payment
                                                        Method</label>
                                                    <select class="form-control" id="payment_method_id"
                                                            name="payment_method_id"
                                                            required>
                                                        <option value="">Select Payment Method</option>
                                                        @foreach($paymentMethods as $method)
                                                            <option
                                                                value="{{ $method->id }}">{{ $method->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Fee Category Dropdown -->
                                                <div class="mb-3">
                                                    <label for="fee_category_id" class="form-label">Fee Category</label>
                                                    <select class="form-control" id="fee_category_id"
                                                            name="fee_category_id"
                                                            required
                                                            onchange="updateFeeItems(this.options[this.selectedIndex].text)">
                                                        <option value="">Select Fee Category</option>
                                                        @foreach($feeCategories as $category)
                                                            <option value="{{ $category->id }}"
                                                                    data-name="{{ $category->name }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Professional Qualifications Dropdown -->
                                                <div class="mb-3" id="professionalQualificationsDiv"
                                                     style="display: none;">
                                                    <label for="professional_qualification_id" class="form-label">Professional
                                                        Qualification</label>
                                                    <select class="form-control" id="professional_qualification_id"
                                                            name="professional_qualification_id"
                                                            onchange="updateSelectedFeeItem()">
                                                        <option value="">Select Professional Qualification</option>
                                                        @foreach($renewal->practitionerProfession->professionalQualifications as $qualification)
                                                            <option value="{{ $qualification->id }}"
                                                                    data-registration-rule-id="{{ $qualification->registration_rule_id }}"
                                                                    data-profession-id="{{ $qualification->profession_id }}">
                                                                @if($qualification->qualification_category_id == 1)
                                                                    {{ $qualification->qualification->name }}
                                                                @else
                                                                    {{ $qualification->qualification_name }}
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <input type="hidden" id="practitionerProfession"
                                                   name="practitioner_profession_id"
                                                   value="{{$renewal->practitionerProfession->id}}">

                                            <div class="col-md-6">
                                                <!-- Fee Items Dropdown -->
                                                <div class="mb-3" id="feeItemsDiv" style="display: none;">
                                                    <label for="dynamic_fee_item_id" class="form-label">Fee Item</label>
                                                    <select class="form-control" id="dynamic_fee_item_id"
                                                            name="fee_item_id">
                                                        <option value="">Select Fee Item</option>
                                                        <!-- Options will be dynamically added here based on the selected fee category -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Currency Dropdown -->
                                                <div class="mb-3">
                                                    <label for="currency_id" class="form-label">Currency</label>
                                                    <select class="form-control" id="currency_id" name="currency_id"
                                                            required>
                                                        <option value="">Select Currency</option>
                                                        @foreach($currencies as $currency)
                                                            <option
                                                                value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Payment Date -->
                                                <div class="mb-3">
                                                    <label for="payment_date" class="form-label">Payment Date</label>
                                                    <input type="text" class="form-control" id="payment_date"
                                                           name="payment_date" required
                                                           placeholder="Choose Payment Date">
                                                </div>
                                            </div>

                                            <!-- Hidden fields for storing the active exchange rate and its ID -->
                                            <input type="hidden" id="hidden_exchange_rate" name="exchange_rate">
                                            <input type="hidden" id="hidden_exchange_rate_id" name="exchange_rate_id">

                                            <div class="col-md-4">
                                                <!-- Amount Input -->
                                                <div class="mb-3">
                                                    <label for="amount_invoiced" class="form-label">Amount
                                                        Invoiced</label>
                                                    <input type="text" class="form-control" id="amount_invoiced"
                                                           name="amount_invoiced" required placeholder="Enter Amount"
                                                           readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <!-- Amount Input -->
                                                <div class="mb-3">
                                                    <label for="amount" class="form-label">Amount in USD</label>
                                                    <input type="number" class="form-control" id="amount" name="amount"
                                                           required
                                                           placeholder="Enter Amount" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <!-- Amount Input -->
                                                <div class="mb-3">
                                                    <label for="amount_paid" class="form-label">Amount Paid</label>
                                                    <input type="number" class="form-control" id="amount_paid"
                                                           name="amount_paid" required
                                                           placeholder="Enter Amount Paid">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Amount Input -->
                                                <div class="mb-3">
                                                    <label for="reference" class="form-label">Transaction Reference
                                                        Number</label>
                                                    <input type="text" min="4" class="form-control" id="reference"
                                                           name="reference"
                                                           required placeholder="For Ecocash">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Amount Input -->
                                                <div class="mb-3">
                                                    <label for="pop" class="form-label">Proof of Payment</label>
                                                    <input type="file" class="form-control" id="pop" name="pop" required
                                                           placeholder="Upload proof of payment">
                                                </div>
                                            </div>

                                        </div>
                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-primary">Submit Payment</button>
                                    </form>

                                </div>
                            </div>
                            <!--end modal-content-->
                        </div>
                        <!--end modal-dialog-->
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
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        function updateFeeItems(selectedCategoryName) {
            const selectedCategory = document.getElementById('fee_category_id').value;
            const feeItemSelect = document.getElementById('dynamic_fee_item_id');
            const feeItemsDiv = document.getElementById('feeItemsDiv');
            const professionalQualificationsDiv = document.getElementById('professionalQualificationsDiv');

            // Clear existing options in the feeItemSelect dropdown
            feeItemSelect.innerHTML = '<option value="">Select Fee Item</option>';

            // Display feeItemsDiv only if a category is selected
            feeItemsDiv.style.display = selectedCategory ? 'block' : 'none';

            // Update feeItemSelect dropdown based on selected fee category
            @json($feeItems).
            forEach((item) => {
                if (item.fee_category_id == selectedCategory) {
                    const option = new Option(item.name, item.id);
                    feeItemSelect.add(option);
                }
            });

            // Handle dropdown enable/disable based on the category
            feeItemSelect.disabled = selectedCategoryName === 'REGISTRATION FEES';

            // Display professionalQualificationsDiv for the "REGISTRATION FEES" category
            professionalQualificationsDiv.style.display = selectedCategoryName === 'REGISTRATION FEES' ? 'block' : 'none';
        }

        function updateSelectedFeeItem() {
            const qualificationSelect = document.getElementById('professional_qualification_id');
            const selectedOption = qualificationSelect.options[qualificationSelect.selectedIndex];
            const registrationRuleId = selectedOption.getAttribute('data-registration-rule-id');

            fetch(`/api/registration-rules/${registrationRuleId}/fee-item`)
                .then(response => response.json())
                .then(data => {
                    const feeItemSelect = document.getElementById('dynamic_fee_item_id');
                    feeItemSelect.value = data.fee_item_id;
                    feeItemSelect.dispatchEvent(new Event('change'));  // Trigger change event to fetch amount
                })
                .catch(error => console.error('Error fetching fee item:', error));
        }

        function fetchFeeItemAmount(feeItemId, practitionerProfessionId) {
            // Construct the URL with the practitionerProfessionId as a query parameter
            const url = `/api/fee-items/${feeItemId}/amount?practitionerProfessionId=${practitionerProfessionId}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const amountInput = document.getElementById('amount'); // Ensure this is the correct ID of your amount input field
                    amountInput.value = data.amount; // Set the fetched amount as the value of the amount input field
                    calculateInvoicedAmount(); // Calculate invoiced amount when fee item is selected
                }).catch(error => console.error('Error fetching fee item amount:', error));
        }

        // Add an event listener for when a fee item is selected
        document.getElementById('dynamic_fee_item_id').addEventListener('change', function () {
            const feeItemId = this.value;
            const practitionerProfessionId = document.getElementById('practitionerProfession').value; // Ensure this retrieves the correct practitioner profession ID
            fetchFeeItemAmount(feeItemId, practitionerProfessionId);

        });

        function calculateInvoicedAmount() {

            const amountInput = document.getElementById('amount'); // Ensure the ID matches your amount input field
            const exchangeRateInput = document.getElementById('hidden_exchange_rate');
            const exchangeRateIdInput = document.getElementById('hidden_exchange_rate_id');
            const amountInvoicedInput = document.getElementById('amount_invoiced');
            const amount = parseFloat(amountInput.value) || 0;
            const exchangeRate = parseFloat(exchangeRateInput.value) || 1;
            amountInvoicedInput.value = (amount * exchangeRate).toFixed(2); // Update the invoiced amount
        }

        // Exchange rate based on currency and payment date
        document.addEventListener('DOMContentLoaded', function () {

            // Ensure this ID matches your amount invoiced field
            const currencyIdField = document.getElementById('currency_id');
            const paymentDateField = document.getElementById('payment_date');
            const exchangeRateInput = document.getElementById('hidden_exchange_rate');
            const exchangeRateIdInput = document.getElementById('hidden_exchange_rate_id');
            const amountInput = document.getElementById('amount'); // Ensure the ID matches your amount input field
            calculateInvoicedAmount(); // Calculate on load to ensure any default values are processed

            // Function to fetch and update exchange rate
            function fetchAndUpdateExchangeRate() {
                const currencyId = currencyIdField.value;
                const paymentDate = paymentDateField.value;
                if (currencyId !== '1' && currencyId.trim() !== '' && paymentDate.trim() !== '') {
                    getActiveExchangeRate(currencyId, paymentDate);
                } else {
                    exchangeRateInput.value = ''; // Clear the exchange rate if criteria not met
                    exchangeRateIdInput.value = ''; // Clear the exchange rate id if criteria not met
                    calculateInvoicedAmount(); // Recalculate amount invoiced with default exchange rate
                }
            }

            // Fetch active exchange rate from the server
            function getActiveExchangeRate(currencyId, paymentDate) {
                fetch(`/api/get-active-exchange-rate/${currencyId}?paymentDate=${paymentDate}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error('Failed to fetch exchange rate:', data.error);
                            return;
                        }
                        exchangeRateInput.value = data.exchange_rate || '1'; // Set the default exchange rate to 1 if none is fetched
                        exchangeRateIdInput.value = data.exchange_rate_id;

                        calculateInvoicedAmount(); // Calculate invoiced amount when new exchange rate is fetched
                    }).catch(error => console.error('Error fetching active exchange rate:', error));
            }

            // Event listeners
            currencyIdField.addEventListener('change', fetchAndUpdateExchangeRate);
            paymentDateField.addEventListener('change', fetchAndUpdateExchangeRate);
            amountInput.addEventListener('input', calculateInvoicedAmount); // Listener for changes in the amount field

            $("#payment_date").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                onSelect: fetchAndUpdateExchangeRate,
                onChangeMonthYear: fetchAndUpdateExchangeRate
            });

            // Initialize DataTables
            $('#buttons-datatables').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'print', 'pdf']
            });

            // Initial calculation
            calculateInvoicedAmount(); // Calculate on load to ensure any default values are processed
        });


    </script>

@endpush

