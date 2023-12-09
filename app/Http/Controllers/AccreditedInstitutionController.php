<?php

namespace App\Http\Controllers;

use App\Models\AccreditedInstitution;
use App\Models\Institution;
use App\Models\Qualification;
use Illuminate\Http\Request;

class AccreditedInstitutionController extends Controller
{
    public function index()
    {
        $accreditedInstitutions = AccreditedInstitution::all();
        return view('accredited_institutions.index', compact('accreditedInstitutions'));
    }

    public function create()
    {
        $institutions = Institution::all();
        $qualifications = Qualification::all();
        return view('accredited_institutions.create', compact('institutions', 'qualifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'institution_id' => 'required|exists:institutions,id',
            'qualification_id' => 'required|exists:qualifications,id',
            // Add validation rules for other accredited institution fields here
        ]);

        AccreditedInstitution::create($request->all());

        return redirect()->route('accredited-institutions.index')
            ->with('success', 'Accredited Institution created successfully.');
    }

    public function show(AccreditedInstitution $accreditedInstitution)
    {
        return view('accredited_institutions.show', compact('accreditedInstitution'));
    }

    public function edit(AccreditedInstitution $accreditedInstitution)
    {
        $institutions = Institution::all();
        $qualifications = Qualification::all();
        return view('accredited_institutions.edit', compact('accreditedInstitution', 'institutions', 'qualifications'));
    }

    public function update(Request $request, AccreditedInstitution $accreditedInstitution)
    {
        $request->validate([
            'institution_id' => 'required|exists:institutions,id',
            'qualification_id' => 'required|exists:qualifications,id',
            // Add validation rules for other accredited institution fields here
        ]);

        $accreditedInstitution->update($request->all());

        return redirect()->route('accredited-institutions.index')
            ->with('success', 'Accredited Institution updated successfully.');
    }

    public function destroy(AccreditedInstitution $accreditedInstitution)
    {
        $accreditedInstitution->delete();

        return redirect()->route('accredited-institutions.index')
            ->with('success', 'Accredited Institution deleted successfully.');
    }
}
