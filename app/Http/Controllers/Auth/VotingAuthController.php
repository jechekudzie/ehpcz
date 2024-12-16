<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Practitioner;
use App\Models\PractitionerProfession;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use App\Services\BudgetSmsService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class VotingAuthController extends Controller
{

    protected $firebaseService;

   /* public function checkRegistration(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string',
        ]);

        $practitionerProfession = PractitionerProfession::where('registration_number', $request->registration_number)->first();

        if (!$practitionerProfession) {
            return response()->json(['error' => 'Invalid Registration Number.'], 404);
        }

        $practitioner = $practitionerProfession->practitioner;
        $contact = $practitioner->contacts()->where('contact_type_id', 1)->first();

        if (!$contact) {
            return response()->json(['error' => 'No mobile number found for ' . $practitioner->first_name], 404);
        }

        return response()->json([
            'mobile_number' => $contact->contact,
            'practitioner_id' => $practitioner->id // Pass practitioner ID
        ]);
    }*/


    public function checkRegistration(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string',
        ]);

        // Check if the practitioner profession exists
        $practitionerProfession = PractitionerProfession::where('registration_number', $request->registration_number)->first();

        if (!$practitionerProfession) {
            return response()->json(['error' => 'Invalid Registration Number.'], 404);
        }

        $practitioner = $practitionerProfession->practitioner;

        // Check if the practitioner has a mobile contact
        $contact = $practitioner->contacts()->where('contact_type_id', 1)->first();

        if (!$contact) {
            return response()->json(['error' => 'No mobile number found for ' . $practitioner->first_name], 404);
        }

        // Check if the practitioner has already voted in the latest election
        $latestElection = \App\Models\Election::latest()->first();
        $hasVoted = false;

        if ($latestElection) {
            $existingVote = \App\Models\Vote::where('practitioner_id', $practitioner->id)
                ->where('election_id', $latestElection->id)
                ->first();

            if ($existingVote) {
                $hasVoted = true;
                // Store practitioner_id in session and redirect in JavaScript
                Session::put('practitioner_id', $practitioner->id);
            }
        }

        return response()->json([
            'mobile_number' => $contact->contact,
            'practitioner_id' => $practitioner->id,
            'has_voted' => $hasVoted, // Send voting status as boolean
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string',
        ]);

        try {
            // Attempt to verify the OTP (Firebase would handle this in the frontend usually)
            $verifiedToken = $this->firebaseService->verifyToken($request->input('otp'));

            Log::info('OTP Verification Successful', ['otp' => $request->input('otp')]);

            if (!$verifiedToken) {
                return redirect()->route('otp.verify.page')->with('error', 'Invalid OTP.');
            }

            return redirect()->route('election-voting.index')->with('success', 'OTP verified successfully!');
        } catch (\Exception $e) {
            Log::error('OTP Verification Failed', ['error' => $e->getMessage()]);
            return redirect()->route('otp.verify.page')->with('error', 'OTP verification failed.');
        }
    }


    public function storeSession(Request $request)
    {
        $request->validate([
            'practitioner_id' => 'required|exists:practitioners,id',
        ]);

        $practitioner = Practitioner::findOrFail($request->practitioner_id);

        // Store in session
        session(['practitioner_id' => $practitioner->id]);

        return response()->json(['success' => true]);
    }



}

