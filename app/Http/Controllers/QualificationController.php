<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use App\Models\Qualification;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    public function index()
    {
        $qualifications = Qualification::all();
        return view('qualifications.index', compact('qualifications'));
    }

    public function create()
    {
        $professions = Profession::all();
        return view('qualifications.create', compact('professions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'profession_id' => 'required|exists:professions,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Add validation for your qualification fields here
        ]);

        Qualification::create($request->all());

        return redirect()->route('qualifications.index')
            ->with('success', 'Qualification created successfully.');
    }

    public function show(Qualification $qualification)
    {
        return view('qualifications.show', compact('qualification'));
    }

    public function edit(Qualification $qualification)
    {
        $professions = Profession::all();
        return view('qualifications.edit', compact('qualification', 'professions'));
    }

    public function update(Request $request, Qualification $qualification)
    {
        $request->validate([
            'profession_id' => 'required|exists:professions,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Add validation for your qualification fields here
        ]);

        $qualification->update($request->all());

        return redirect()->route('qualifications.index')
            ->with('success', 'Qualification updated successfully.');
    }

    public function destroy(Qualification $qualification)
    {
        $qualification->delete();

        return redirect()->route('qualifications.index')
            ->with('success', 'Qualification deleted successfully.');
    }
}
