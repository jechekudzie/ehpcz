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
            'id_number' => 'required|string',
        ]);

        try {
            $formattedId = formatZimbabweanId($request->input('id_number'));
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['id_number' => $e->getMessage()]);
        }

        dd($formattedId); // This should now show the formatted ID
        // Find the practitioner profession by registration number
        $practitionerProfession = PractitionerProfession::where('registration_number', $request->registration_number)->first();

        // Check if practitioner profession exists
        if (!$practitionerProfession || !$practitionerProfession->practitioner) {
            return redirect()->route('voting.login')->with('error', 'Registration number not found.');
        }


        // Get the practitioner from practitioner profession
        $practitioner = $practitionerProfession->practitioner;



        // Store practitioner ID in the session
        Session::put('practitioner_id', $practitioner->id);

        return redirect()->route('election-voting.index', ['election' => Session::get('current_election_id')])
            ->with('success', 'You are now logged in and can vote!');
    }


}
