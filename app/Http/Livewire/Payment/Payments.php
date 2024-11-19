<?php

namespace App\Http\Livewire\Payment;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\{Payment,
    PaymentBreakdown,
    Penalty,
    PractitionerProfession,
    RegistrationRule,
    Renewal,
    PaymentMethod,
    Currency,
    FeeCategory,
    FeeItem,
    ExchangeRate,
    ProfessionalQualification
};
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Paynow\Payments\Paynow;

class Payments extends Component
{
    use WithFileUploads;

    public $renewal;
    public $renewalId; // Store only ID instead of the whole model

    public $paymentMethods, $currencies, $feeCategories, $feeItems = [], $professionalQualifications = [];
    public $selectedPaymentMethod, $selectedFeeCategory, $selectedFeeItem, $selectedCurrency, $selectedProfessionalQualification;
    public $paymentDate, $amountInvoiced, $exchangeAmount, $amountPaid, $reference, $exchangeRate = null;
    public $pop, $mobileNumber, $receiptNumber, $pollUrl;// For file upload
    public $showProfessionalQualifications = false;
    public $selectedProfessionalQualificationId;
    public $registrationRule;
    public $practitionerProfession;
    public $selectedReadOnly = false;
    public $selectedFeeItemSubmit;
    public $currenyName;

    public $balance;
    public $penaltyFee = 0;
    public $totalAmountInvoiced;
    public $feeItemSubmit;

    //declare step variable
    public $currentStep = 1;

    public function increaseStep()
    {

        $this->currentStep++;
    }

    public function decreaseStep()
    {
        $this->currentStep--;
    }

    public function goToStep2()
    {
        // Define validation rules for Step 1
        $this->validate([
            'selectedFeeCategory' => 'required',
            'selectedFeeItem' => 'required',
            'selectedCurrency' => 'required',
            'paymentDate' => 'required|date',
            'amountInvoiced' => 'required|numeric',
        ]);

        // If validation passes, move to Step 2
        $this->currentStep = 2;
    }


    public function mount(Renewal $renewal)
    {
        $this->renewal = $renewal;
        $this->renewalId = $renewal->id;
        $this->loadRenewal();
        $this->currenyName = '$USD';
        $this->initializeStaticData();
        // Fetch the balance
        $this->calculateTotalBalance();
    }

    public function updated($propertyName)
    {
        Log::debug("Updated property: $propertyName", [$this->$propertyName]);

    }

    public function loadRenewal()
    {
        $this->renewal = Renewal::find($this->renewalId);
    }

    private function initializeStaticData()
    {
        $this->paymentMethods = Cache::remember('payment-methods', 60, function () {
            return PaymentMethod::all();
        });
        $this->currencies = Currency::all();  // Assuming this doesn't change often
        $this->feeCategories = FeeCategory::all();
        $this->practitionerProfession = $this->renewal->practitionerProfession;

    }

    public function calculateTotalBalance()
    {
        // Fetch all renewals related to this practitioner's profession, including their payments
        $renewals = $this->practitionerProfession->renewals()->with('payments')->get();

        // Use the reduce method to sum up all the balances from the payments of each renewal
        $totalBalance = $renewals->reduce(function ($carry, $renewal) {
            $sumPayments = $renewal->payments->sum('balance');
            return $carry + $sumPayments;
        }, 0);

        // Store the calculated total balance in the component's state
        $this->balance = $totalBalance;
    }

    public function checkForPenalties()
    {
        Log::info("Checking penalties for selected fee category: {$this->selectedFeeCategory}");

        $category = $this->feeCategories->where('id', $this->selectedFeeCategory)->first();
        if ($category && $category->name === 'ANNUAL FEES') {
            $currentMonth = Carbon::now()->month;
            $expiryMonth = $this->practitionerProfession->profession->expiry_month;

            Log::info("Current month: {$currentMonth}, Expiry month: {$expiryMonth}");

            if ($currentMonth > $expiryMonth) {
                $monthDifference = $currentMonth - $expiryMonth;
                Log::info("Month difference: {$monthDifference}");

                $penalty = Penalty::first();
                if ($monthDifference <= $penalty->threshold) {
                    // Apply penalty if the month difference is 6 or less
                    $this->applyPenalty($monthDifference);

                } else {
                    // Change fee category to RESTORATION FEES and reset penalties
                    $this->selectedFeeCategory = $this->feeCategories->where('name', 'RESTORATION FEES')->first()->id;

                    $this->updatedSelectedFeeCategory($this->selectedFeeCategory);

                    $this->penaltyFee = 0;

                }
                $this->updateAmountInvoiced();
            }
        }
    }

    private function applyPenalty($monthDifference)
    {
        $penalty = Penalty::first();
        if ($penalty) {
            $penaltyPercentage = $penalty->percentage / 100; //eg 20% = 0.20
            $penaltyFee = $monthDifference * $penaltyPercentage * $this->amountInvoiced;
            Log::info("Calculated penalty fee: {$penaltyFee}");

            if ($this->selectedCurrency && $this->exchangeRate !== null) {
                $this->penaltyFee = $penaltyFee * $this->exchangeRate->rate;
            } else {
                $this->penaltyFee = $penaltyFee;
            }
            Log::info("Final penalty fee: {$this->penaltyFee}");

        }
    }

    public function updatedSelectedFeeCategory($value)
    {
        $this->resetSelectedData();
        if (!$value) return;
        $this->loadFeeItems($value);
        $this->determineQualificationsVisibility($value);
        $this->checkForPenalties();

    }

    private function loadFeeItems($value)
    {
        // Fetch all fee items for the selected fee category
        $feeItems = FeeItem::with(['professions' => function ($query) {
            // Optionally, you can restrict the professions loaded here, but it might be better for filtering later
            $query->where('profession_id', $this->practitionerProfession->profession_id);
        }])
            ->where('fee_category_id', $value)
            ->get();

        // Filter to find the first fee item that has a matching profession fee
        $selectedItem = $feeItems->first(function ($item) {
            return $item->professions->isNotEmpty();
        });

        // Set the fee items to the component state
        $this->feeItems = $feeItems;

        // Set the selected fee item if one is found
        if ($selectedItem) {
            $this->selectedFeeItem = $selectedItem->id;
            // If a profession fee is found, set the amount invoiced
            $this->updateAmountInvoiced();
            $this->feeItemSubmit = FeeItem::find($this->selectedFeeItem);
            if ($this->selectedFeeItem == $selectedItem->id) {
                $this->selectedReadOnly = true;
            }
        } else {
            // Reset or handle the case where no matching fee item is found
            $this->selectedFeeItem = null;
        }
    }

    private function determineQualificationsVisibility($value)
    {
        $category = $this->feeCategories->where('id', $value)->first();
        $this->showProfessionalQualifications = $category && $category->name === 'REGISTRATION FEES';

        if ($this->showProfessionalQualifications) {
            $this->loadProfessionalQualifications();
        } else {
            $this->professionalQualifications = collect();
        }
    }

    public function loadProfessionalQualifications()
    {
        $professionalQualifications = collect();
        foreach ($this->renewal->practitioner->practitionerProfessions as $profession) {
            $professionalQualifications = $professionalQualifications->merge($profession->professionalQualifications);
        }

        // Ensure all items are treated as objects if they aren't already
        $this->professionalQualifications = $professionalQualifications->map(function ($item) {
            return is_array($item) ? (object)$item : $item;
        });
    }

    private function resetSelectedData()
    {
        $this->selectedFeeItem = null;
        $this->selectedProfessionalQualificationId = null;
        $this->professionalQualifications = collect();
        $this->amountInvoiced = null;
        $this->totalAmountInvoiced = null;
        $this->selectedReadOnly = false;
        $this->exchangeAmount = null;
    }

    public function updatedSelectedProfessionalQualificationId($value)
    {
        if (!empty($value)) {
            // Fetch the professional qualification object from the collection of qualifications.
            $this->selectedProfessionalQualification = $this->professionalQualifications->firstWhere('id', $value);

            // Find the matching registration rule
            $this->registrationRule = RegistrationRule::find($this->selectedProfessionalQualification['registration_rule_id']);
            $this->selectedFeeItem = $this->registrationRule->feeItem->id;
            $this->updateAmountInvoiced();
        } else {
            // If no ID is selected (e.g., if the selection is cleared), clear the selectedProfessionalQualification.
            $this->selectedProfessionalQualification = null;
        }
    }

    public function updatedSelectedFeeItem($value)
    {
        if (!empty($value) && !empty($this->selectedProfessionalQualificationId)) {
            $this->selectedFeeItem = $this->registrationRule->feeItem->id;
            $this->feeItemSubmit = FeeItem::find($this->selectedFeeItem);
        } else {
            $this->selectedFeeItem = $value;
            $this->feeItemSubmit = FeeItem::find($value);
        }
        // Update the amount invoiced
        $this->updateAmountInvoiced();
    }

    //updateAmountInvoiced method is used to update the amount invoiced based on the selected fee item
    public function updateAmountInvoiced()
    {
        if (!$this->selectedFeeItem) return;

        $feeItem = FeeItem::find($this->selectedFeeItem);
        if (!$feeItem) return; // Ensure the fee item was found

        // Check if the selected fee item amount is 0, which implies a need to fetch from profession_fees
        if ($feeItem->amount == 0.00) {
            $professionFee = $feeItem->professions()
                ->where('profession_id', $this->practitionerProfession->profession_id)
                ->first();

            // If a related profession fee is found, use the amount from the pivot table
            if ($professionFee) {
                $this->amountInvoiced = (int)$professionFee->pivot->amount;
            }
        } else {
            $this->amountInvoiced = (int)$feeItem->amount;

        }
        $this->updateTotalAmountInvoiced();

        $this->updateExchangeRate();
    }

    public function updateTotalAmountInvoiced()
    {
        $this->totalAmountInvoiced = $this->amountInvoiced + $this->penaltyFee + $this->balance;
    }

    public function updateExchangeRate()
    {
        // Pre-condition checks
        if (!$this->selectedCurrency || $this->selectedCurrency == 1 || !$this->paymentDate) {
            $this->exchangeAmount = $this->totalAmountInvoiced;
            $this->exchangeRate = null;
            return;
        }
        try {
            // Fetch rate
            $rate = ExchangeRate::getRateForCurrencyPairAndDate(1, $this->selectedCurrency, new Carbon($this->paymentDate));
            if ($rate) {
                $this->exchangeRate = $rate;
                $this->exchangeAmount = $this->totalAmountInvoiced * $this->exchangeRate->rate;
            } else {
                $this->exchangeRate = null;
                $this->exchangeAmount = $this->totalAmountInvoiced;
            }
        } catch (\Exception $e) {
            Log::error('Exchange rate fetching error', [
                'error' => $e->getMessage(),
                'currencyId' => $this->selectedCurrency,
                'date' => $this->paymentDate
            ]);
            $this->exchangeAmount = $this->totalAmountInvoiced;
            session()->flash('error', 'Failed to fetch the exchange rate. Please try again.');
            return;
        }
    }

    public function updatedSelectedCurrency($value)
    {
        $this->updateExchangeRate();
        $this->currenyName = Currency::find($value)->symbol;

    }

    public function updatedPaymentDate()
    {
        $this->updateExchangeRate();
    }

    public function updatedAmountPaid($value)
    {
        if ($value === '') {
            $this->amountPaid = '0.00';
        }

        $this->validate([
            'amountPaid' => 'numeric|max:' . $this->exchangeAmount,
        ]);
        if ($value > $this->exchangeAmount) {
            $this->addError('amountPaid', 'The amount paid cannot exceed the exchange amount.');
        }

    }


    public function savePayment()
    {
        Log::debug("savePayment method called.");

        $validatedData = $this->validate([
            'selectedPaymentMethod' => 'required',
            'selectedFeeCategory' => 'required',
            'selectedFeeItem' => 'required',
            'selectedCurrency' => 'required',
            'paymentDate' => 'required|date',
            'amountInvoiced' => 'required|numeric',
            'totalAmountInvoiced' => 'required|numeric',
            'amountPaid' => 'required|numeric',
            'exchangeAmount' => 'required|numeric',
            'reference' => 'nullable',
            'pop' => 'nullable',
            'mobileNumber' => 'nullable',
            'receiptNumber' => 'nullable',
            'pollUrl' => 'nullable|url'
        ]);

        // Determine the payment method
        $paymentMethod = PaymentMethod::find($this->selectedPaymentMethod);

        // Prepare data for storage or session
        $paymentData = [
            'practitioner_id' => $this->practitionerProfession->practitioner_id,
            'period' => $this->renewal->period,
            'renewal_id' => $this->renewal->id,
            'payment_method_id' => $this->selectedPaymentMethod,
            'fee_category_id' => $this->selectedFeeCategory,
            'fee_item_id' => $this->selectedFeeItem,
            'currency_id' => $this->selectedCurrency,
            'payment_date' => $this->paymentDate,
            'amount_invoiced' => $this->totalAmountInvoiced,
            'total_amount_invoiced' => $this->totalAmountInvoiced,
            'amount_paid' => $this->amountPaid,
            'exchange_amount' => $this->exchangeAmount,
            'exchange_rate' => $this->exchangeRate ? $this->exchangeRate->rate : null,
            'exchange_rate_id' => $this->exchangeRate ? $this->exchangeRate->id : null,
            'reference' => $this->reference ?? null,
            'mobile_number' => $this->mobileNumber ?? null,
            'receipt_number' => $this->receiptNumber ?? null,
            'poll_url' => $this->pollUrl ?? null,
            'balance' => null,
            'professional_qualification_id' => $this->selectedProfessionalQualificationId ?? null,
        ];

        $paymentBreakdowns = [
            [
                'payment_item' => FeeItem::find($this->selectedFeeItem)->name,
                'amount_invoiced' => $this->amountInvoiced,
                'description' => ''
            ],
            [
                'payment_item' => 'Balance',
                'amount_invoiced' => $this->balance,
                'description' => 'Previous balance'
            ],
            [
                'payment_item' => 'Penalty',
                'amount_invoiced' => $this->penaltyFee,
                'description' => 'Previous balance'
            ]
        ];

        if ($paymentMethod && $paymentMethod->name == 'Paynow Online') {
            // Store payment details in the session for Paynow Online and redirect
            $transactionReference = 'INV' . strtoupper(uniqid());

            //selected fee item name
            $feeItem = FeeItem::find($this->selectedFeeItem);

            $payNow = $this->payNow($this->selectedCurrency, $transactionReference);

            // Create a new payment
            $payment = $payNow->createPayment($transactionReference, 'admin@leadingdigital.africa');

            // Add items to the payment
            $payment->add($feeItem->name, $this->amountPaid);

            // Set the payment to be paid using payment methods
            $response = $payNow->send($payment);

            if ($response->success()) {
                $pollUrl = $response->pollUrl();
                $paymentData['poll_url'] = $pollUrl;
            } else {
                throw new \Exception('Failed to initiate payment');
            }

            session(['payment_details' => $paymentData, 'payment_breakdowns' => $paymentBreakdowns]);

            return redirect($response->redirectUrl());

        } else {
            // Directly store the payment data
            $payment = new Payment($paymentData);

            // Calculate the balance in the transaction currency
            $remainingBalance = $this->exchangeAmount - $this->amountPaid;

            // Check if the selected currency is not USD (assuming '1' is USD)
            if ($this->selectedCurrency != 1) {
                // Convert the balance back to USD
                $usdBalance = $remainingBalance / $this->exchangeRate->rate; // Ensure that exchangeRate->rate is not zero
                $payment->balance = $usdBalance;
            } else {
                $payment->balance = $remainingBalance; // No conversion needed if in USD
            }

            if ($this->pop) {
                // First, store the file in the public disk under 'payments/{period}/pop'
                $path = $this->pop->store('payments/' . $this->renewal->period . '/pop', 'public');

                // Determine the original and new paths
                $originalPath = storage_path('app/public/' . $path);
                $publicPath = public_path('payments/' . $this->renewal->period . '/pop/' . basename($path));

                // Ensure the target directory exists
                $publicDir = dirname($publicPath);
                if (!file_exists($publicDir)) {
                    mkdir($publicDir, 0777, true);
                }

                // Move the file
                if (file_exists($originalPath)) {
                    rename($originalPath, $publicPath);
                }
                // Update the path in the database to reflect the public directory
                $payment->proof_of_payment = 'payments/' . $this->renewal->period . '/pop/' . basename($path);
            }

            $payment->save();

            $practitioner = $this->renewal->practitioner;
            $renewal = $this->renewal;

            // After saving the payment, update all other payments' balances to zero
            $previousPayments = $practitioner->payments;

            foreach ($previousPayments as $prevPayment) {
                if ($prevPayment->id != $payment->id) {
                    $prevPayment->balance = 0;
                    $prevPayment->save();
                }
            }

            //save payment breakdowns
            foreach ($paymentBreakdowns as $breakdown) {
                $breakdown['payment_id'] = $payment->id;
                $paymentBreakdown = new PaymentBreakdown($breakdown);
                $paymentBreakdown->save();
            }

            //check if professional_qualification_id is not null
            if ($this->selectedProfessionalQualificationId != null) {
                $professionalQualification = ProfessionalQualification::findOrFail($this->selectedProfessionalQualificationId);
                $professionalQualification->payments()->attach($payment->id, ['renewal_period' => $renewal->period]);
            }

            // Clear session and redirect after payment
            session()->forget('payment_details');
            session()->flash('message', 'Payment successfully processed.');


            return redirect()->route('renewals.payments.summary', ['renewal' => $renewal->id, 'payment' => $payment->id]);

        }
    }

    public function payNow($currency, $reference)
    {

        //zwl
        if ($currency == '1') {
            //USD
            /* $payNow = new Paynow(
                 '16178',
                 '9611042b-e7f8-4409-a586-8a7766c4ae5f',
                 'http://localhost:8000/renewals/'.$reference.'/payments/paynow/update',
                 'http://localhost:8000/renewals/'.$reference.'/payments/paynow/update',
             );*/

            $payNow = new Paynow(
                '5865',
                '23962222-9610-4f7c-bbd5-7e12f19cdfc6',
                'http://localhost:8000/renewals/' . $reference . '/payments/paynow/update',
                'http://localhost:8000/renewals/' . $reference . '/payments/paynow/update',
            );

        } else {
            /*$payNow = new Paynow(
                '13194',
                '450e0e1a-5792-40ce-b1d7-88168435f042',
                'http://localhost:8000/renewals/'.$reference.'/payments/paynow/update',
                'http://localhost:8000/renewals/'.$reference.'/payments/paynow/update',
            );*/

            $payNow = new Paynow(
                '5865',
                '23962222-9610-4f7c-bbd5-7e12f19cdfc6',
                'http://localhost:8000/renewals/' . $reference . '/payments/paynow/update',
                'http://localhost:8000/renewals/' . $reference . '/payments/paynow/update',
            );
        }


        return $payNow;

    }

    public function render()
    {

        return view('livewire.payment.payments', [
            'professionalQualifications' => $this->professionalQualifications,
            'currencyName' => $this->currenyName,
        ]);
    }
}
