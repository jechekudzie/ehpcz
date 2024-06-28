<div>

    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


@if (session()->has('success'))
        <!-- Success Alert -->
        <div class="alert alert-outline-success d-flex align-items-center" role="alert">
            <span class="fas fa-check-circle text-success fs-3 me-3"></span>
            <p class="mb-0 flex-1">{{ session('success') }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form wire:submit.prevent="savePayment" enctype="multipart/form-data">
        @csrf
        @if ($currentStep == 1)
            <div class="row">
                <!-- Fee Category Dropdown -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fee_category_id" class="form-label">Fee Category</label>
                        <select class="form-control" wire:model="selectedFeeCategory">
                            <option value="">Select Fee Category</option>
                            @foreach($feeCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Fee Items Dropdown -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fee_item_id" class="form-label">Fee Item </label>
                        <select class="form-control"
                                wire:model="selectedFeeItem" {{  $this->selectedReadOnly == true ? 'disabled' : '' }}>
                            <option value="">Select Fee Item</option>
                            @foreach($feeItems as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Hidden input to submit the selected value -->
                <input type="hidden" wire:model="selectedFeeItem" name="selectedFeeItemSubmit">

                <!-- Professional Qualification -->
                @if($showProfessionalQualifications && $professionalQualifications->count() > 0)
                    <div class="col-md-12" wire:if="$showProfessionalQualifications">
                        <div class="mb-3">
                            <div>
                                <div class="form-group">
                                    <label for="professional_qualification_id">Professional
                                        Qualification</label>
                                    <select id="professional_qualification_id" class="form-control"
                                            wire:model="selectedProfessionalQualificationId">
                                        <option value="">Select Professional Qualification</option>
                                        @foreach ($professionalQualifications as $professionalQualification)
                                            <option
                                                value="{{ $professionalQualification['id'] }}" {{ $professionalQualification['id'] == $selectedFeeItem ? 'selected' : '' }}>
                                                {{ $professionalQualification['qualification_name'] ?? $professionalQualification['qualification']['name']}}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>

                        </div>
                    </div>
                @endif

                <!-- Currency Dropdown -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="currency_id" class="form-label">Currency</label>
                        <select class="form-control" wire:model="selectedCurrency">
                            <option value="">Select Currency</option>
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Payment Date Input -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payment_date" class="form-label">Payment Date </label>
                        <input wire:model.debounce.500ms="paymentDate" type="text" id="datepicker" class="form-control"
                               placeholder="Enter Payment Date">
                    </div>
                </div>

                <!-- Amount Invoiced Input -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="amount_invoiced" class="form-label">Amount Invoiced</label>
                        <input type="text" class="form-control" wire:model="amountInvoiced" readonly>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="total_amount_invoiced" class="form-label">Total Amount Invoiced</label>
                        <input type="text" class="form-control" wire:model="totalAmountInvoiced" readonly>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="exchange_amount" class="form-label">Exchange Amount ({{ $currencyName }})</label>
                        <input type="number" class="form-control" wire:model="exchangeAmount" id="exchange_amount"
                               readonly>
                    </div>
                </div>

                <div class="input-row">
                    <div class="input-column full-width">
                        <button type="button" class="btn btn-danger w-70" wire:click="goToStep2">Next</button>
                    </div>
                </div>

                @elseif ($currentStep == 2)
                    <div class="row">
                        <div class="col-12">
                            <h3 class="mb-3">Payment Summary</h3>
                            <p>{{ date('m') }}{{$practitionerProfession->profession->expiry_month}} {{$currentStep}}</p>
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Description</th>
                                    <th scope="col">Amount
                                        ({{ $selectedCurrency ? $currencies->find($selectedCurrency)->name : 'USD' }})
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td> {{ $feeItemSubmit->name ?? '' }}</td>
                                    <td>{{ $selectedCurrency && $exchangeRate ? '$' . number_format($amountInvoiced * $exchangeRate->rate, 2) : '$' . number_format($amountInvoiced, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Current Balance</td>
                                    <td>{{ $selectedCurrency && $exchangeRate ? '$' . number_format($balance * $exchangeRate->rate, 2) : '$' . number_format($balance, 2) }}</td>
                                </tr>
                                @if($penaltyFee > 0)
                                    <tr>
                                        <td>Penalty</td>
                                        <td>{{ $selectedCurrency && $exchangeRate ? '$' . number_format($penaltyFee * $exchangeRate->rate, 2) : '$' . number_format($penaltyFee, 2) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><strong>Total Due</strong></td>
                                    <td>
                                        <strong>{{ $selectedCurrency && $exchangeRate ? '$' . number_format(($amountInvoiced + $balance + $penaltyFee) * $exchangeRate->rate, 2) : '$' . number_format($amountInvoiced + $balance + $penaltyFee, 2) }}</strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" wire:click="decreaseStep">Back to Details</button>
                            <button class="btn btn-primary" wire:click="increaseStep">Proceed to Payment</button>
                        </div>
                    </div>

                @elseif ($currentStep == 3)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method_id" class="form-label">Payment Method</label>
                                    <select class="form-control" wire:model.lazy="selectedPaymentMethod">
                                        <option value="">Select Payment Method</option>
                                        @foreach($paymentMethods as $method)
                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if($selectedPaymentMethod)
                                {{-- Dynamically show instructions or fields based on the payment method --}}
                                @php
                                    $paymentMethod = $paymentMethods->where('id', $selectedPaymentMethod)->first();
                                @endphp
                                @if($paymentMethod->name == 'Transfer - USD' || $paymentMethod->name == 'Transfer - ZWL' || $paymentMethod->name == 'Swipe - ZWL')
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pop" class="form-label">Proof of Payment</label>
                                            <input type="file" class="form-control" wire:model="pop">
                                            <small class="form-text text-black">Please upload the proof of payment (bank
                                                transfer receipt).</small>
                                        </div>
                                    </div>
                                @elseif($paymentMethod->name == 'Ecocash - USD' || $paymentMethod->name == 'Ecocash - ZWL' || $paymentMethod->name == 'Ecocash Biller')
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="reference" class="form-label">Transaction Reference
                                                Number</label>
                                            <input type="text" class="form-control" wire:model="reference">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="mobile_number" class="form-label">Mobile Number Used</label>
                                            <input type="text" class="form-control" wire:model="mobileNumber">
                                        </div>
                                    </div>
                                    <small class="form-text text-black col-md-12">Enter the mobile number and
                                        transaction
                                        reference from your EcoCash payment.</small>
                                @elseif($paymentMethod->name == 'CASH - USD' || $paymentMethod->name == 'CASH - ZWL')
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="receiptNumber" class="form-label">Receipt Number</label>
                                            <input type="text" class="form-control" wire:model="receiptNumber">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="form-text text-black">Provide your receipt number as per
                                            transaction
                                            recorded at EHPCZ.</small>
                                    </div>
                                @elseif($paymentMethod->name == 'Paynow Online')
                                    <div class="col-md-6">
                                        <small class="form-text text-black">You will be redirected to Paynow to complete
                                            your payment Online.</small>
                                    </div>
                                @endif

                                <!-- Amount Paid/To Pay Input -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="amountPaid" class="form-label">Amount Paid/To Pay
                                            (in {{ \App\Models\Currency::find($selectedCurrency)->name }} )</label>
                                        <input type="number" class="form-control" wire:model.lazy="amountPaid"
                                               placeholder="Enter the amount paid">
                                        @error('amountPaid') <span
                                            class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif
                            <br/>
                            <br/>
                            <div class="col-12">
                                <button class="btn btn-primary" wire:click="decreaseStep">Back to Summary</button>
                                <button type="button" class="btn btn-success" wire:click="savePayment">Confirm Payment
                                </button>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Display exchangeAmount, amountPaid, and remaining balance -->
                            <div class="mb-3">
                                <label>Total Amount Due</label>
                                <div
                                    class="alert alert-info">{{ number_format($exchangeAmount, 2) }} {{ \App\Models\Currency::find($selectedCurrency)->name ?? '' }}</div>
                            </div>
                            <div class="mb-3">
                                <label>Amount Paid / To Pay</label>
                                <div
                                    class="alert alert-success">{{ number_format($amountPaid, 2) }} {{ \App\Models\Currency::find($selectedCurrency)->name ?? '' }}</div>
                            </div>
                            <div class="mb-3">
                                <label>Remaining Balance</label>
                                <div
                                    class="alert alert-warning">{{ number_format($exchangeAmount - $amountPaid, 2) }} {{ \App\Models\Currency::find($selectedCurrency)->name ?? '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
    </form>
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

                    // Update the Livewire component
                @this.set('paymentDate', dateText)
                    ;
                }
            });
        });

        document.addEventListener('livewire:update', function () {
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

                    // Update the Livewire component
                @this.set('paymentDate', dateText)
                    ;
                }
            });
        });
    </script>
    <!-- Ensure you have Livewire scripts included -->
    @livewireScripts

</div>
