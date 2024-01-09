<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Practitioner;
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

    public function store(Request $request,Practitioner $practitioner)
    {
        $validator = Validator::make($request->all(), [

            'contact_type_id' => [
                'required',
                Rule::unique('contacts')->where(function ($query) use ($practitioner) {
                    return $query->where('practitioner_id', $practitioner->id);
                })
            ],
            'country_code' => 'nullable',
            'contact' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'contactErrors')
                ->withInput();
        }

        $validatedData['contact_type_id'] = $request->contact_type_id;
        $validatedData['country_code'] = $request->country_code;
        $validatedData['contact'] = $request->contact;

        //dd($validatedData);
        $practitioner->createContact($validatedData);

        return redirect()->route('practitioners.show',$practitioner->slug)
            ->with('contact_success', 'Contact created successfully.');
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
