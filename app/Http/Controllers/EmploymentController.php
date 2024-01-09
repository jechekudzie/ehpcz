<?php

namespace App\Http\Controllers;

use App\Models\Employment;
use App\Models\Practitioner;
use Illuminate\Http\Request;

class EmploymentController extends Controller
{
    //index method
    public function index(Practitioner $practitioner)
    {
        return view('practitioners.employment.index',compact('practitioner'));
    }

    //create method
    public function create(Practitioner $practitioner)
    {
        return view('practitioners.employment.create',compact('practitioner'));
    }

    //store method
    public function store(Request $request, Practitioner $practitioner)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'employment_sector_id' => 'required|exists:employment_sectors,id',
            'country_id' => 'nullable|exists:countries,id',
            'province_id' => 'nullable|exists:provinces,id',
            'city_id' => 'nullable|exists:cities,id',
            'employer' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'required|boolean',
        ]);

        // Create the employment record
        $practitioner->createEmployment($validatedData);

        // Redirect with success message
        return redirect()->route('practitioner-employments.index',$practitioner->slug)->with('success', 'Employment details added successfully.');
    }

    //edit method
    public function edit(Employment $employment)
    {
        $practitioner = $employment->practitioner;
        return view('practitioners.employment.edit',compact('practitioner','employment'));
    }

    //update method
    public function update(Request $request, Employment $employment)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'employment_sector_id' => 'required|exists:employment_sectors,id',
            'country_id' => 'nullable|exists:countries,id',
            'province_id' => 'nullable|exists:provinces,id',
            'city_id' => 'nullable|exists:cities,id',
            'employer' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'required|boolean',
        ]);

        // Update the employment record
        $employment->update($validatedData);

        // Redirect with success message
        return redirect()->route('practitioner-employments.index',$employment->practitioner->slug)->with('success', 'Employment details updated successfully.');
    }
}
