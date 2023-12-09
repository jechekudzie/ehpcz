<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use App\Models\RequirementsCategory;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    public function index()
    {
        $requirements = Requirement::all();
        return view('requirements.index', compact('requirements'));
    }

    public function create()
    {
        $categories = RequirementsCategory::all();
        return view('requirements.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'requirements_category_id' => 'required|exists:requirements_categories,id',
            'name' => 'required|string|max:255',
        ]);

        Requirement::create($request->all());

        return redirect()->route('requirements.index')
            ->with('success', 'Requirement created successfully.');
    }

    public function show(Requirement $requirement)
    {
        return view('requirements.show', compact('requirement'));
    }

    public function edit(Requirement $requirement)
    {
        $categories = RequirementsCategory::all();
        return view('requirements.edit', compact('requirement', 'categories'));
    }

    public function update(Request $request, Requirement $requirement)
    {
        $request->validate([
            'requirements_category_id' => 'required|exists:requirements_categories,id',
            'name' => 'required|string|max:255',
        ]);

        $requirement->update($request->all());

        return redirect()->route('requirements.index')
            ->with('success', 'Requirement updated successfully.');
    }

    public function destroy(Requirement $requirement)
    {
        $requirement->delete();

        return redirect()->route('requirements.index')
            ->with('success', 'Requirement deleted successfully.');
    }
}
