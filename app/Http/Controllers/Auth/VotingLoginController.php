<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PractitionerProfession;
use Illuminate\Http\Request;
use App\Models\Practitioner;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;

class VotingLoginController extends Controller
{
    protected $twilio;

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
            $formattedId = formatZimbabweanId($request->input('id_number'));
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['id_number' => $e->getMessage()]);
        }

        $practitionerProfession = PractitionerProfession::where('registration_number', $request->registration_number)->first();

        if (!$practitionerProfession || !$practitionerProfession->practitioner) {
            return redirect()->route('voting.login')->with('error', 'Registration number not found.');
        }

        $practitioner = $practitionerProfession->practitioner;

        Session::put('practitioner_id', $practitioner->id);

        $mobileNumberToUse = $this->processMobileNumber($practitioner, $request->mobile_number);

        if (!$mobileNumberToUse) {
            return back()->withErrors(['mobile_number' => 'This mobile number is already in use by another practitioner.']);
        }

        // Check if the practitioner has already voted in the latest election
        $latestElection = \App\Models\Election::latest()->first();

        if ($latestElection) {
            $existingVote = \App\Models\Vote::where('practitioner_id', $practitioner->id)
                ->where('election_id', $latestElection->id)
                ->first();

            if ($existingVote) {
                // Redirect to the election voting page with a message
                return redirect()->route('election-voting.index', ['election' => $latestElection->id])
                    ->with('info', 'You have already voted in this election. You can update your vote.');
            }else{
                //return to voting page
                return redirect()->route('election-voting.index', ['election' => $latestElection->id]);

            }
        }
        //return to voting page
        return redirect()->route('election-voting.index', ['election' => $latestElection->id]);


    }

    public function showOTPVerificationForm($practitioner_id, $election_id, $mobile_number, $id_number)
    {
        return view('auth.verify_otp', compact('practitioner_id', 'election_id', 'mobile_number', 'id_number'));
    }


    public function edit(Practitioner $practitioner)
    {
        return view('elections.practitioners.edit', compact('practitioner'));
    }

    public function update(Request $request, Practitioner $practitioner)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'id_number' => 'required|string',
            'mobile_number' => 'required|string',
        ]);

        $formattedMobileNumber = $this->formatToE164($request->mobile_number, '263');

        // Check if the practitioner already has a mobile number
        $existingContact = $practitioner->contacts()->where('contact_type_id', 1)->first();

        if ($existingContact) {
            // Notify the practitioner that the contact cannot be updated
            return back()->withErrors([
                'mobile_number' => 'You already have an existing mobile number (' . $existingContact->contact . '). Updates can only be made via the EHPCZ admin.'
            ]);
        }

        // Check for duplicate mobile numbers globally
        $duplicateContact = \App\Models\Contact::where(function ($query) use ($formattedMobileNumber, $request) {
            $query->where('contact', $formattedMobileNumber)
                ->orWhere('contact', $request->mobile_number);
        })->where('contact_type_id', 1)
            ->where('practitioner_id', '!=', $practitioner->id)
            ->exists();

        if ($duplicateContact) {
            return back()->withErrors(['mobile_number' => 'This mobile number is already in use by another practitioner.']);
        }

        // Add the new mobile number
        $practitioner->contacts()->updateOrCreate(
            ['contact_type_id' => 1],
            ['contact' => $formattedMobileNumber]
        );

        // Check if the practitioner already has an ID number
        $existingIdentification = $practitioner->practitionerIdentifications()
            ->where('identification_type_id', 1) // Assuming 1 is the ID type for national ID
            ->first();

        if ($existingIdentification) {
            return back()->withErrors([
                'id_number' => 'You already have an existing ID number (' . $existingIdentification->identification_number . '). Updates can only be made via the EHPCZ admin.'
            ]);
        }

        try {
            $formattedId = formatZimbabweanId($request->input('id_number'));
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['id_number' => $e->getMessage()]);
        }

        // Add the new ID number
        $practitioner->practitionerIdentifications()->updateOrCreate(
            ['identification_type_id' => 1], // Assuming 1 is the ID type for national ID
            ['identification_number' => $formattedId]
        );

        // Update practitioner details
        $practitioner->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        $latestElection = \App\Models\Election::latest()->first();

        // Redirect to voting page
        return redirect()->route('election-voting.index', ['election' => $latestElection->id])
            ->with('success', 'Practitioner details updated successfully.');
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

    private function processMobileNumber($practitioner, $mobileNumber)
    {
        $formattedMobileNumber = $this->formatToE164($mobileNumber, '263');

        $globalDuplicate = \App\Models\Contact::where(function ($query) use ($formattedMobileNumber, $mobileNumber) {
            $query->where('contact', $formattedMobileNumber)
                ->orWhere('contact', $mobileNumber);
        })->where('contact_type_id', 1)
            ->first();

        if ($globalDuplicate && $globalDuplicate->practitioner_id !== $practitioner->id) {
            return null; // Number belongs to another practitioner
        }

        return $formattedMobileNumber;
    }

    private function updatePractitionerDetails($practitioner, $idNumber, $mobileNumber)
    {
        $practitioner->practitionerIdentifications()->updateOrCreate(
            ['identification_type_id' => 1],
            ['identification_number' => $idNumber]
        );

        $practitioner->contacts()->updateOrCreate(
            ['contact_type_id' => 1],
            ['contact' => $mobileNumber]
        );
    }

    public function logout()
    {
        Session::forget('practitioner_id');
        return redirect()->route('voting.login')->with('success', 'You have been logged out successfully.');
    }
}
