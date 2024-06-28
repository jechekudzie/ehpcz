<?php

namespace App\Http\Controllers;

use App\Models\Renewal;
use Illuminate\Http\Request;

class ContinuousProfessionalDevelopmentController extends Controller
{
    //index
    public function index(Renewal $renewal)
    {
        $continuous_professional_developments = $renewal->continuous_professional_developments;
        $practitioner = $renewal->practitioner;
        return view('practitioners.cpds.index', compact('continuous_professional_developments', 'renewal', 'practitioner'));
    }

    //store
    public function store(Request $request, Renewal $renewal)
    {
        $validatedData = $request->validate([
            'points' => 'required',
            'file' => 'required',
            'practitioner_id' => 'required'
        ]);

        $practitioner = $renewal->practitioner;

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imagePath = 'cpd_files/' . $practitioner->first_name . '_' . $practitioner->last_name; // The directory where you want to save the files
            $imageName = time() . '_' . $image->getClientOriginalName(); // Customizing the file name to be unique
            $image->move(public_path($imagePath), $imageName); // Move the image to the specified directory

            // Set the image path in the validated data
            $validatedData['file'] = $imagePath . '/' . $imageName;
        }


        $renewal->continuousProfessionalDevelopments()->create([
            'period' => $renewal->period,
            'points' => $validatedData['points'],
            'file' => $validatedData['file'],
            'practitioner_id' => $validatedData['practitioner_id']
        ]);

        return redirect()->route('renewal.cpd.index', $renewal->id)->with('success', 'CPD added successfully');
    }

    //update
    public function update(Request $request, Renewal $renewal, $id)
    {
        $validatedData = $request->validate([
            'points' => 'required',
            'file' => 'required',
            'practitioner_id' => 'required'
        ]);

        $practitioner = $renewal->practitioner;

        //check for old file
        $cpd = $renewal->continuousProfessionalDevelopments()->find($id);
        $oldFile = $cpd->file;

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imagePath = 'cpd_files/' . $practitioner->first_name . '_' . $practitioner->last_name; // The directory where you want to save the files
            $imageName = time() . '_' . $image->getClientOriginalName(); // Customizing the file name to be unique
            $image->move(public_path($imagePath), $imageName); // Move the image to the specified directory

            // Set the image path in the validated data
            $validatedData['file'] = $imagePath . '/' . $imageName;
        }

        $cpd = $renewal->continuousProfessionalDevelopments()->find($id);
        $cpd->update([
            'points' => $validatedData['points'],
            'file' => $validatedData['file'],
            'practitioner_id' => $validatedData['practitioner_id']
        ]);

        //unlink old file if it exists
        if (file_exists($oldFile)) {
            unlink($oldFile);
        }

        return redirect()->route('renewal.cpd.index', $renewal->id)->with('success', 'CPD updated successfully');
    }

}
