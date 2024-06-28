<?php

namespace App\Http\Controllers;

use App\Models\Practitioner;
use App\Models\PractitionerProfession;
use App\Models\ProfessionalQualification;
use App\Models\QualificationCategory;
use App\Models\Requirement;
use Illuminate\Http\Request;

class ProfessionalQualificationController extends Controller
{
    //index method return index view
    public function index(PractitionerProfession $practitionerProfession)
    {
        $practitioner = $practitionerProfession->practitioner;

        return view('practitioners.qualifications.index', compact('practitionerProfession', 'practitioner'));
    }

    public function store(Request $request, PractitionerProfession $practitionerProfession)
    {
        $practitioner = $practitionerProfession->practitioner;

        // Basic validation rules that apply to both local and foreign qualifications
        $rules = [
            'qualification_category_id' => 'required|exists:qualification_categories,id',
            'qualification_level_id' => 'required|exists:qualification_levels,id',
            'register_id' => 'nullable|exists:registers,id',
            'start_date' => 'nullable|date',
            'completion_date' => 'nullable|date',
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
        $qualification = $practitionerProfession->createProfessionalQualification($validatedData);

        //requirements
        $requirements = Requirement::whereNotIn('id', [1, 2, 3])->get();

        $qualification->qualificationFiles()->createMany($requirements->map(function ($requirement) {
            return [
                'requirement_id' => $requirement->id,
                'file' => null
            ];
        })->toArray());

        // Determine if the practitioner is Zimbabwean
        $isZimbabwean =  $practitioner->country->name == 'Zimbabwe' ? 1 : 0;

        $registrationRule = $qualification->findMatchingRegistrationRuleId($practitionerProfession, $isZimbabwean, $qualification->qualification_category_id);
        $qualification->registration_rule_id = $registrationRule->id ?? '';
        $qualification->register_id = $registrationRule->register_id ?? '';
        $qualification->save();

        // Redirect back with a success message
        return redirect()->route('practitioner-professional-qualifications.index', $practitionerProfession->slug)->with('success', 'Professional qualification added successfully.');
    }

    //edit method return edit view
    public function edit(ProfessionalQualification $professionalQualification)
    {
        $practitionerProfession = $professionalQualification->practitionerProfession;
        $practitioner = $practitionerProfession->load('practitioner');

        return view('practitioners.qualifications.edit', compact('practitionerProfession', 'practitioner', 'professionalQualification'));
    }

    //update method update the data
    public function update(Request $request, ProfessionalQualification $professionalQualification)
    {
        //$qualification = $practitionerProfession->professionalQualifications()->findOrFail($qualificationId);
        $practitionerProfession = $professionalQualification->practitionerProfession;

        // Basic validation rules that apply to both local and foreign qualifications
        $rules = [
            'qualification_category_id' => 'required|exists:qualification_categories,id',
            'qualification_level_id' => 'required|exists:qualification_levels,id',
            'register_id' => 'nullable|exists:registers,id',
            'start_date' => 'nullable|date',
            'completion_date' => 'nullable|date',
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

        // Update the qualification data
        $professionalQualification->update($validatedData);

        // Update files if needed, can be adapted to update only changes or additions
        $requirements = Requirement::whereNotIn('id', [1, 2, 3])->get();
        $existingFiles = $professionalQualification->qualificationFiles;

        $existingFiles->each(function($file) use ($requirements) {
            if (!$requirements->contains('id', $file->requirement_id)) {
                $file->delete(); // Remove files that are no longer needed
            }
        });

        foreach ($requirements as $requirement) {
            $professionalQualification->qualificationFiles()->updateOrCreate(
                ['requirement_id' => $requirement->id],
                ['file' => null] // Assuming no new file data provided
            );
        }

        // Update registration rule and other related fields
        $isZimbabwean = $practitionerProfession->practitioner->country->name == 'Zimbabwe' ? 1 : 0;

        $registrationRule = $professionalQualification->findMatchingRegistrationRuleId($practitionerProfession, $isZimbabwean, $professionalQualification->qualification_category_id);
        $professionalQualification->registration_rule_id = $registrationRule->id;
        $professionalQualification->register_id = $registrationRule->register_id;
        $professionalQualification->save();

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
