<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalQualification;
use App\Models\QualificationFile;
use App\Models\Requirement;
use Illuminate\Http\Request;

class ProfessionalQualificationFilesController extends Controller
{
    //
    public function index(ProfessionalQualification $professionalQualification)
    {
        $qualificationFiles = $professionalQualification->qualificationFiles()->get();

        $practitioner = $professionalQualification->practitionerProfession->practitioner;

        return view('practitioners.qualifications.add_files', compact('professionalQualification','qualificationFiles','practitioner'));
    }

    public function update(Request $request, ProfessionalQualification $professionalQualification)
    {
        $practitioner = $professionalQualification->practitionerProfession->practitioner;


        $validatedData = $request->validate([
            'id' => 'required|exists:qualification_files,id',
            'file' => 'required|file',
        ]);

        $qualificationFile = QualificationFile::find($validatedData['id']);


        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imagePath = 'qualification_files/'.$practitioner->first_name.'_'.$practitioner->last_name; // The directory where you want to save the files
            $imageName = time() . '_' . $image->getClientOriginalName(); // Customizing the file name to be unique
            $image->move(public_path($imagePath), $imageName); // Move the image to the specified directory

            // Set the image path in the validated data
            $validatedData['file'] = $imagePath . '/' . $imageName;
        }

        $qualificationFile->update($validatedData);

        return redirect()->route('practitioner-professional-qualifications.file.index', $professionalQualification->slug)->with('success', 'File added successfully.');
    }
}
