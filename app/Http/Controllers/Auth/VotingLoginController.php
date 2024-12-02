<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Models\PractitionerProfession;
use Illuminate\Http\Request;
use App\Models\Practitioner;
use Illuminate\Support\Facades\Session;
use App\Services\TwilioService;

class VotingLoginController extends Controller
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function showLoginForm()
    {
        return view('auth.login_for_voting');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'registration_number' => 'required',
            'id_number' => 'required|string',
            'mobile_number' => 'required|string',
        ]);

        try {
            // Format the ID
            $formattedId = formatZimbabweanId($request->input('id_number'));
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['id_number' => $e->getMessage()]);
        }

        // Find the practitioner profession by registration number
        $practitionerProfession = PractitionerProfession::where('registration_number', $request->registration_number)->first();

        if (!$practitionerProfession || !$practitionerProfession->practitioner) {
            return redirect()->route('voting.login')->with('error', 'Registration number not found.');
        }

        $practitioner = $practitionerProfession->practitioner;

        // Check if the practitioner already owns the mobile number
        $existingContact = $practitioner->contacts()
            ->where('contact', $request->mobile_number)
            ->where('contact_type_id', 1) // Ensure it's a mobile number
            ->first();

        if ($existingContact) {
            // Use the practitioner's existing number if correctly formatted
            $mobileNumberToUse = $this->formatToE164($existingContact->contact, '263');
        } else {
            // Check for global duplicates
            $formattedMobileNumber = $this->formatToE164($request->mobile_number, '263');
            $globalDuplicate = \App\Models\Contact::where(function ($query) use ($formattedMobileNumber, $request) {
                $query->where('contact', $formattedMobileNumber)
                    ->orWhere('contact', $request->mobile_number); // Check both formatted and unformatted
            })->where('contact_type_id', 1)->first();

            if ($globalDuplicate) {
                if ($globalDuplicate->practitioner_id !== $practitioner->id) {
                    // If the number exists globally but belongs to another practitioner
                    return back()->withErrors(['mobile_number' => 'This mobile number is already in use by another practitioner.']);
                } else {
                    // Use the existing contact if it belongs to the same practitioner
                    $mobileNumberToUse = $formattedMobileNumber;
                }
            } else {
                // If no duplicates, use the newly provided number
                $mobileNumberToUse = $formattedMobileNumber;
            }
        }

        try {
            // Send OTP using Twilio
            $this->twilio->sendOTP($mobileNumberToUse);

            // Temporarily store practitioner details for OTP verification
            Session::put('practitioner_temp_id', $practitioner->id);

            return redirect()->route('otp.verify', [
                'practitioner_id' => $practitioner->id,
                'election_id' => Session::get('current_election_id'),
                'mobile_number' => $mobileNumberToUse,
                'id_number' => $formattedId,
            ])->with('success', 'OTP sent successfully.');
        } catch (\Exception $e) {
            return redirect()->route('voting.login')->with('error', 'Failed to send OTP: ' . $e->getMessage());
        }
    }

    public function showOTPVerificationForm($practitioner_id, $election_id, $mobile_number, $id_number)
    {
        return view('auth.verify_otp', compact('practitioner_id', 'election_id', 'mobile_number', 'id_number'));
    }


    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'mobile_number' => 'required|string',
            'practitioner_id' => 'required',
            'election_id' => 'required',
            'id_number' => 'required',
        ]);

        try {
            $isVerified = $this->twilio->verifyOTP($request->mobile_number, $request->otp);

            if ($isVerified) {
                $practitioner = Practitioner::findOrFail($request->practitioner_id);

                // Update or create identification
                $practitioner->practitionerIdentifications()->updateOrCreate(
                    [
                        'identification_number' => $request->id_number, // Search criteria
                    ],
                    [
                        'identification_type_id' => 1, // Fields to update or create
                    ]
                );

                // Update or create contact
                $practitioner->contacts()->updateOrCreate(
                    [
                        'contact' => $request->mobile_number, // Search criteria
                    ],
                    [
                        'contact_type_id' => 1, // Fields to update or create
                    ]
                );

                // After verification, set the practitioner_id in the session
                Session::put('practitioner_id', $practitioner->id);

                return redirect()->route('election-voting.index', [
                    'election' => $request->election_id,
                ])->with('success', 'OTP Verified. You can now vote!');
            } else {
                return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => 'Failed to verify OTP: ' . $e->getMessage()]);
        }
    }

    private function formatToE164($number, $countryCode)
    {
        $number = preg_replace('/\s+/', '', $number); // Remove spaces
        if (!preg_match('/^\+/', $number)) {
            if (strpos($number, '0') === 0) {
                $number = '+' . $countryCode . substr($number, 1);
            } else {
                $number = '+' . $countryCode . $number;
            }
        }

        return preg_match('/^\+\d{10,15}$/', $number) ? $number : null;
    }

    public function logout()
    {
        Session::forget('practitioner_id');
        return redirect()->route('voting.login')->with('success', 'You have been logged out successfully.');
    }


    // Show the update form
    public function edit(Practitioner $practitioner)
    {
        return view('elections.practitioners.edit', compact('practitioner'));
    }

    // Handle update request
    public function update(Request $request, Practitioner $practitioner)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'id_number' => 'required|string|unique:practitioner_identifications,identification_number,' . $practitioner->id . ',practitioner_id',
            'mobile_number' => 'required|string',
        ]);

        // Format the provided mobile number
        $formattedMobileNumber = $this->formatToE164($request->mobile_number, '263');

        // Check for global duplicate contacts
        $duplicateContact = \App\Models\Contact::where(function ($query) use ($formattedMobileNumber, $request) {
            $query->where('contact', $formattedMobileNumber)
                ->orWhere('contact', $request->mobile_number); // Check both formatted and unformatted numbers
        })->where('contact_type_id', 1)
            ->where('practitioner_id', '!=', $practitioner->id) // Exclude the current practitioner
            ->exists();

        if ($duplicateContact) {
            return back()->withErrors(['mobile_number' => 'This mobile number is already in use by another practitioner.']);
        }

        // Update practitioner details
        $practitioner->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        // Update or create practitioner identification
        $practitioner->practitionerIdentifications()->updateOrCreate(
            ['identification_type_id' => 1], // Assuming 1 is the ID type for the national ID
            ['identification_number' => $request->id_number]
        );

        // Update or create contact details
        $practitioner->contacts()->updateOrCreate(
            ['contact_type_id' => 1], // Assuming 1 is the contact type for mobile number
            ['contact' => $formattedMobileNumber]
        );

        // Send OTP using Twilio
        try {
            $this->twilio->sendOTP($formattedMobileNumber);

            // Redirect to the OTP verification form
            return redirect()->route('practitioner.verify.otp', [
                'practitioner' => $practitioner->slug,
            ])->with('success', 'OTP has been sent for verification, to proceed please the OTP before');
        } catch (\Exception $e) {
            return back()->withErrors(['mobile_number' => 'Failed to send OTP: ' . $e->getMessage()]);
        }
    }

    // Show the OTP verification form
    public function showVerifyOtpForm(Practitioner $practitioner)
    {
        return view('elections.practitioners.verify_otp', compact('practitioner'));
    }

    public function verifyOtpForPractitioner(Request $request, Practitioner $practitioner)
    {
        $request->validate([
            'otp' => 'required|string',
            'mobile_number' => 'required|string',
        ]);

        // Format the provided mobile number
        $formattedMobileNumber = $this->formatToE164($request->mobile_number, '263');

        // Check for global duplicate contacts
        $duplicateContact = \App\Models\Contact::where(function ($query) use ($formattedMobileNumber, $request) {
            $query->where('contact', $formattedMobileNumber)
                ->orWhere('contact', $request->mobile_number); // Check both formatted and unformatted numbers
        })->where('contact_type_id', 1)
            ->where('practitioner_id', '!=', $practitioner->id) // Exclude the current practitioner
            ->exists();

        if ($duplicateContact) {
            return back()->withErrors(['mobile_number' => 'This mobile number is already in use by another practitioner.']);
        }

        // Verify the OTP using Twilio
        try {
            $isVerified = $this->twilio->verifyOTP($formattedMobileNumber, $request->otp);

            if ($isVerified) {
                // Update the practitioner's contact
                $practitioner->contacts()->updateOrCreate(
                    ['contact_type_id' => 1],
                    ['contact' => $formattedMobileNumber]
                );

                // Set the session for the authenticated practitioner
                Session::put('practitioner_id', $practitioner->id);

                return redirect()->route('election-voting.index', [
                    'election' => Session::get('current_election_id'),
                ])->with('success', 'Details updated and mobile number verified successfully. You can now vote!');
            } else {
                return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => 'Failed to verify OTP: ' . $e->getMessage()]);
        }
    }


}
