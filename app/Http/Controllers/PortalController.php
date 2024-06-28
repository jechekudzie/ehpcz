<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Practitioner;
use App\Models\PractitionerProfession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PortalController extends Controller
{
//index
    public function index()
    {
        return view('practitioners.portal.index');
    }

  // Check existence and update/create contact details
    public function checkExistence(Request $request)
    {
   // Request and validate registration number
        $validatedData = $request->validate([
            'registration_number' => 'required',
            'identification_type_id' => 'required',
            'identification_number' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

    // Check if registration number exists
        $practitionerProfession = PractitionerProfession::where('registration_number', $validatedData['registration_number'])->first();

        if (!$practitionerProfession) {
            $message = '<a href="' . route('portal.practitioner-data') . '">Submit Your Data To The Council</a>.';
            return back()->with('error', 'Practitioner not found. Make sure to provide a valid registration number. ' . $message);

        } else {
            $practitioner = $practitionerProfession->practitioner;
    // Update or create phone contact
            $practitioner->contacts()->updateOrCreate(
                [
                    'contact_type_id' => 1  // Condition to match in the database
                ],
                [
                    'contact' => $validatedData['phone']  // Data to update or create
                ]);

     // Update or create email contact
            $practitioner->contacts()->updateOrCreate(
                [
                    'contact_type_id' => 3  // Condition to match in the database
                ],
                [
                    'contact' => $validatedData['email']  // Data to update or create
                ]);

     // Update or create practitioner identification
            $practitioner->practitionerIdentifications()->updateOrCreate(
                [
                    'identification_type_id' => $validatedData['identification_type_id']  // Condition to match in the database
                ],
                [
                    'identification_number' => $validatedData['identification_number']  // Data to update or create
                ]);

    // Prepare data for redirection
            $registration_number = $validatedData['registration_number'];
            $email = $validatedData['email'];
            $identification_number = $validatedData['identification_number'];

    // Redirect to confirm page with data
            return redirect()->route('portal.confirm', compact('practitioner', 'registration_number', 'email', 'identification_number','practitionerProfession'));
        }
    }

    // Confirm page with registration details
    public function confirm(Request $request, Practitioner $practitioner, $registration_number, $email, $identification_number, PractitionerProfession $practitionerProfession)
    {
        return view('practitioners.portal.confirm', compact('practitioner', 'registration_number', 'email',
            'identification_number', 'practitionerProfession'));
    }


     // Register a new user
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'practitioner_id' => 'required|exists:practitioners,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       // Registration logic
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role
        $user->assignRole('practitioner');

        // Attach user to practitioner
        $practitioner = Practitioner::findOrFail($request->practitioner_id);
        $practitioner->users()->attach($user->id);

        return redirect()->route('portal.index')->with('success', 'Registration successful. Please log in.');
    }

    //login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $practitioner = $user->practitioners->first();

            if ($practitioner) {
                return redirect()->route('practitioners.show', $practitioner->slug)->with('success', 'Logged in successfully.');
            } else {
                Auth::logout();
                return back()->with('error', 'This user is not associated with any practitioner.');
            }
        }

        return back()->with('error', 'Invalid login details.');
    }
}
