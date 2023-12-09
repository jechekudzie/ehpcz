<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index()
    {
        $institutions = Institution::all();
        return view('institutions.index', compact('institutions'));
    }

    public function create()
    {
        return view('institutions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Add validation rules for other institution fields here
        ]);

        Institution::create($request->all());

        return redirect()->route('institutions.index')
            ->with('success', 'Institution created successfully.');
    }

    public function show(Institution $institution)
    {
        return view('institutions.show', compact('institution'));
    }

    public function edit(Institution $institution)
    {
        return view('institutions.edit', compact('institution'));
    }

    public function update(Request $request, Institution $institution)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Add validation rules for other institution fields here
        ]);

        $institution->update($request->all());

        return redirect()->route('institutions.index')
            ->with('success', 'Institution updated successfully.');
    }

    public function destroy(Institution $institution)
    {
        $institution->delete();

        return redirect()->route('institutions.index')
            ->with('success', 'Institution deleted successfully.');
    }
}
