<?php

namespace App\Http\Controllers;

use App\Models\Practitioner;
use App\Models\PractitionerProfession;
use App\Models\ProfessionalQualification;
use App\Models\QualificationCategory;
use Illuminate\Http\Request;

class ProfessionalQualificationController extends Controller
{
    //index method return index view
    public function index(PractitionerProfession $practitionerProfession)
    {
        $practitioner = $practitionerProfession->practitioner;

        return view('practitioners.qualifications.index',compact('practitionerProfession','practitioner'));
    }

    public function store(Request $request, PractitionerProfession $practitionerProfession)
    {

        $practitioner = $practitionerProfession->practitioner;

        // Basic validation rules that apply to both local and foreign qualifications
        $rules = [
            'qualification_category_id' => 'required|exists:qualification_categories,id',
            'qualification_level_id' => 'required|exists:qualification_levels,id',
            'register_id' => 'required|exists:registers,id',
            'start_date' => 'nullable|date',
            'completion_date' => 'nullable|date|after_or_equal:start_date',
        ];

        // Retrieve the qualification category to determine additional validation
        $qualificationCategory = QualificationCategory::find($request->input('qualification_category_id'));

        if ($qualificationCategory && $qualificationCategory->name == 'Local') {
            // Add rules specific to local qualifications
            $rules['qualification_id'] = 'required|exists:qualifications,id';
            $rules['institution_id'] = 'required|exists:institutions,id';
        } elseif ($qualificationCategory && $qualificationCategory->name == 'Foreign') {
            // Add rules specific to foreign qualifications
            $rules['qualification_name'] = 'required|string|max:255';
            $rules['institution_name'] = 'required|string|max:255';
        }

        // Perform validation
        $validatedData = $request->validate($rules);

        // Continue with storing the data
        $practitionerProfession->createProfessionalQualification($validatedData);

        // Redirect back with a success message
        return redirect()->route('practitioner-professional-qualifications.index', $practitionerProfession->slug)->with('success', 'Professional qualification added successfully.');
    }
    //edit method return edit view
    public function edit(ProfessionalQualification $professionalQualification)
    {
        $practitionerProfession = $professionalQualification->practitionerProfession;
        $practitioner = $practitionerProfession->load('practitioner');

        return view('practitioners.qualifications.edit',compact('practitionerProfession','practitioner','professionalQualification'));
    }

    //update method update the data
    public function update(Request $request, ProfessionalQualification $professionalQualification)
    {
        $practitionerProfession = $professionalQualification->practitionerProfession;
        $practitioner = $practitionerProfession->practitioner;

        // Basic validation rules that apply to both local and foreign qualifications
        $rules = [
            'qualification_category_id' => 'required|exists:qualification_categories,id',
            'qualification_level_id' => 'required|exists:qualification_levels,id',
            'register_id' => 'required|exists:registers,id',
            'start_date' => 'nullable|date',
            'completion_date' => 'nullable|date|after_or_equal:start_date',
        ];

        // Retrieve the qualification category to determine additional validation
        $qualificationCategory = QualificationCategory::find($request->input('qualification_category_id'));

        if ($qualificationCategory && $qualificationCategory->name == 'Local') {
            // Add rules specific to local qualifications
            $rules['qualification_id'] = 'required|exists:qualifications,id';
            $rules['institution_id'] = 'required|exists:institutions,id';
        } elseif ($qualificationCategory && $qualificationCategory->name == 'Foreign') {
            // Add rules specific to foreign qualifications
            $rules['qualification_name'] = 'required|string|max:255';
            $rules['institution_name'] = 'required|string|max:255';
        }

        // Perform validation
        $validatedData = $request->validate($rules);

        // Continue with storing the data
        $professionalQualification->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('practitioner-professional-qualifications.index', $practitionerProfession->slug)->with('success', 'Professional qualification updated successfully.');
    }

    //destroy method delete the data
    public function destroy(ProfessionalQualification $professionalQualification)
    {
        $practitionerProfession = $professionalQualification->practitionerProfession;
        $practitioner = $practitionerProfession->practitioner;

        $professionalQualification->delete();

        // Redirect back with a success message
        return redirect()->route('practitioner-professional-qualifications.index', $practitionerProfession->slug)->with('success', 'Professional qualification deleted successfully.');
    }

}
