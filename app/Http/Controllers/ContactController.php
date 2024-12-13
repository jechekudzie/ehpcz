<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Practitioner;
use App\Rules\ValidEmailDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('contacts.create');
    }


    public function store(Request $request, Practitioner $practitioner)
    {
        // Basic validation rules
        $rules = [
            'contact_type_id' => 'required|exists:contact_types,id', // Ensure the contact type exists in your 'contact_types' table
            'country_code' => 'required', // Make country code mandatory for mobile and telephone
            'contact' => ['required'], // Contact is required
        ];

        // Adjust rules based on contact_type_id for mobile and telephone
        if ($request->input('contact_type_id') == '1' || $request->input('contact_type_id') == '2') {
            // For mobile and telephone, append regex validation for exactly 10 digits
            $rules['contact'][] = 'regex:/^[0-9]{10}$/'; // Must be exactly 10 digits
        } else {
            // For other types, like email, apply appropriate validation
            $rules['contact'][] = 'email'; // For email, ensure it's valid
        }

        // Validation
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'contactErrors')
                ->withInput();
        }

        $validatedData = $validator->validated();

        // Format the mobile number for contact_type_id 1 (mobile) and 2 (telephone)
        if (in_array($validatedData['contact_type_id'], ['1', '2'])) {
            $validatedData['contact'] = $this->formatPhoneNumber(
                $validatedData['contact'],
                $validatedData['country_code']
            );
        }

        // Check if a contact with the given contact_type_id exists for this practitioner
        $contact = $practitioner->contacts()->where('contact_type_id', $validatedData['contact_type_id'])->first();

        if ($contact) {
            // If the contact exists, update it
            $contact->update($validatedData);
            $message = 'Contact updated successfully.';
        } else {
            // If the contact doesn't exist, create a new one
            $practitioner->createContact($validatedData);
            $message = 'Contact created successfully.';
        }

        return redirect()->route('practitioners.show', $practitioner->slug)
            ->with('contact_success', $message);
    }

    /**
     * Format the phone number to include the country code and remove leading zeros.
     *
     * @param string $phoneNumber
     * @param string $countryCode
     * @return string
     */

    private function formatPhoneNumber(string $phoneNumber, string $countryCode): string
    {
        // Remove non-numeric characters from the phone number
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Remove leading zero if it exists
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = substr($phoneNumber, 1);
        }

        // Concatenate the '+' with the country code and the phone number
        return '+' . $countryCode . $phoneNumber;
    }




    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        // Validation rules
        $rules = [
            'practitioner_id' => 'required',
            'contact_type_id' => 'required',
            'contact' => 'required',
            'country_code' => 'required', // Ensure country code is provided
        ];

        // Adjust rules based on contact_type_id for mobile and telephone
        if ($request->input('contact_type_id') == '1' || $request->input('contact_type_id') == '2') {
            $rules['contact'] = ['required', 'regex:/^[0-9]{10}$/']; // Ensure contact is 10 digits
        }

        // Validate the request
        $validatedData = $request->validate($rules);

        // Format the phone number if it is mobile or telephone
        if (in_array($validatedData['contact_type_id'], ['1', '2'])) {
            $validatedData['contact'] = $this->formatPhoneNumber(
                $validatedData['contact'],
                $validatedData['country_code']
            );
        }

        // Update the contact with the validated and formatted data
        $contact->update($validatedData);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}
