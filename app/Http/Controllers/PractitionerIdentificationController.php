<?php

namespace App\Http\Controllers;

use App\Models\Practitioner;
use App\Models\PractitionerIdentification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PractitionerIdentificationController extends Controller
{
    //

    // Store a new identification
    public function store(Request $request, Practitioner $practitioner)
    {

        //initialise identificationErrors variable
        $identificationErrors = null;

        $validator = Validator::make($request->all(), [
            'identification_type_id' => [
                'required',
                Rule::unique('practitioner_identifications')->where(function ($query) use ($practitioner) {
                    return $query->where('practitioner_id', $practitioner->id);
                })
            ],
            'identification_number' => 'required',
            'identification_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'identificationErrors')
                ->withInput();
        }

        $validatedData = $validator->validated();

        //add image upload code using move method
        if ($request->hasFile('identification_file')) {
            $image = $request->file('identification_file');
            $imagePath = 'images/practitioners/identification_files'; // The directory where you want to save the files
            $imageName = time() . '_' . $image->getClientOriginalName(); // Customizing the file name to be unique
            $image->move(public_path($imagePath), $imageName); // Move the image to the specified directory

            // Set the image path in the validated data
            $validatedData['identification_file'] = $imagePath . '/' . $imageName;
        }

        $practitioner->createPractitionerIdentifications($validatedData);

        return redirect()->route('practitioners.show', $practitioner->slug)
            ->with('identification_success', 'Identification added successfully.');

    }

    // Show the form for editing the specified identification
    public function edit($practitioner_slug, $identification)
    {
        $identification = PractitionerIdentification::findOrFail($identification);
        return view('practitionerIdentifications.edit', compact('identification'));
    }

    // Update the specified identification
    public function update(Request $request, PractitionerIdentification $practitionerIdentification)
    {

        $practitioner = $practitionerIdentification->practitioner;

        //initialise identificationErrors variable
        $identificationErrors = null;

        $validator = Validator::make($request->all(), [
            'identification_type_id' => 'required',
            'identification_number' => 'required',
            'identification_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'identificationErrors')
                ->withInput();
        }

        $validatedData = $validator->validated();

        //add image upload code using move method
        if ($request->hasFile('identification_file')) {
            $image = $request->file('identification_file');
            $imagePath = 'images/practitioners/identification_files'; // The directory where you want to save the files
            $imageName = time() . '_' . $image->getClientOriginalName(); // Customizing the file name to be unique

            // Check if an existing file is present and delete it
            if ($practitionerIdentification->identification_file != null) {
                $file_path = public_path($practitionerIdentification->identification_file);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            // Move the new image to the specified directory
            $image->move(public_path($imagePath), $imageName);

            // Set the new image path in the validated data
            $validatedData['identification_file'] = $imagePath . '/' . $imageName;

        }
        $practitionerIdentification->update($validatedData);

        return redirect()->route('practitioners.show', $practitioner->slug)
            ->with('identification_success', 'Identification updated successfully.');

    }


    // Remove the specified identification
    public function destroy($practitioner_slug, $identification)
    {
        $identification = PractitionerIdentification::findOrFail($identification);
        $identification->delete();

        return redirect()->route('some-route')->with('success', 'Identification deleted successfully.');
    }

}
