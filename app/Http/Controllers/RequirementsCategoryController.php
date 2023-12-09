<?php

namespace App\Http\Controllers;

use App\Models\RequirementsCategory;
use Illuminate\Http\Request;

class RequirementsCategoryController extends Controller
{
    public function index()
    {
        $categories = RequirementsCategory::all();
        return view('requirements_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('requirements_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        RequirementsCategory::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Requirements category created successfully.');
    }

    public function show(RequirementsCategory $category)
    {
        return view('requirements_categories.show', compact('category'));
    }

    public function edit(RequirementsCategory $category)
    {
        return view('requirements_categories.edit', compact('category'));
    }

    public function update(Request $request, RequirementsCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Requirements category updated successfully.');
    }

    public function destroy(RequirementsCategory $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Requirements category deleted successfully.');
    }
}
