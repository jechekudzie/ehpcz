<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PractitionerProfession;
use Illuminate\Http\Request;
use App\Models\Practitioner;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VotingLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login_for_voting');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'registration_number' => 'required',

        ]);


        //first get practitionerProfessions, then get the first profession then get registration number
        $practitionerProfession = PractitionerProfession::where('registration_number', $request->registration_number)->first();

        $practitioner = $practitionerProfession->practitioner;

        if (!$practitioner) {
            return redirect()->route('voting.login')->with('error', 'Registration number not found.');
        }


        // Store practitioner ID in the session
        Session::put('practitioner_id', $practitioner->id);

        return redirect()->route('election-voting.index', ['election' => Session::get('current_election_id')])
            ->with('success', 'You are now logged in and can vote!');
    }

}
