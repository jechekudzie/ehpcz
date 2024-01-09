<?php

namespace App\Http\Controllers;

use App\Models\Practitioner;
use App\Models\PractitionerProfession;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PractitionerProfessionsController extends Controller
{
    //index method
    public function index(Practitioner $practitioner)
    {
        return view('practitioners.professions.index',compact('practitioner'));
    }


    public function store(Request $request, Practitioner $practitioner)
    {
        // Validate the request data
        $validatedData = $request->validate([

            'profession_id' => [
                'required',
                Rule::unique('practitioner_professions')->where(function ($query) use ($practitioner) {
                    return $query->where('practitioner_id', $practitioner->id);
                })
            ],
            'registration_number' => 'nullable|unique:practitioner_professions,registration_number',
            'registration_date' => 'nullable|date',
        ]);

        // Create a new practitioner profession record
       $practitioner->createPractitionerProfession($validatedData);
        // Redirect with a success message
        return redirect()->route('practitioner-professions.index',$practitioner->slug)->with('success', 'Profession details added successfully.');
    }

    //edit method pass practitionerProfession
    public function edit(PractitionerProfession $practitionerProfession)
    {
        $practitioner = $practitionerProfession->practitioner;
        return view('practitioners.professions.edit', compact('practitioner', 'practitionerProfession'));
    }

    //update method
    public function update(Request $request, PractitionerProfession $practitionerProfession)
    {
        // Validate the request data
        $validatedData = $request->validate([

            'profession_id' => 'required',
            'registration_number' => 'nullable',
            'registration_date' => 'nullable|date',
        ]);

        // Update the practitioner profession record
        $practitionerProfession->update($validatedData);

        // Redirect with a success message
        return redirect()->route('practitioner-professions.index',$practitionerProfession->practitioner->slug)->with('success', 'Profession details updated successfully.');
    }


}
