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
            'country_code' => 'nullable', // Default to nullable
        ];

        // Adjust rules based on contact_type_id for mobile and telephone
        if ($request->input('contact_type_id') == '1' || $request->input('contact_type_id') == '2') {
            // For mobile and telephone, append regex validation for exactly 10 digits
            $rules['contact'] = ['required', 'regex:/^[0-9]{10}$/'];  // Convert to array and include the regex
            $rules['country_code'] = 'required'; // Make country code mandatory for mobile and telephone
        } else {
            // For other types, like email, apply appropriate validation
            // Here, we convert the existing rules to an array and add the custom rule for ValidEmailDomain
            $rules['contact'] = ['required', 'email', new ValidEmailDomain];
        }

        // Validation
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'contactErrors')
                ->withInput();
        }

        $validatedData = $validator->validated();

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
        $request->validate([
            'practitioner_id' => 'required',
            'contact_type_id' => 'required',
            'contact' => 'required',
        ]);

        $contact->update($request->all());

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
