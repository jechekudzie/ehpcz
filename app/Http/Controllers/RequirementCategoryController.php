<?php

namespace App\Http\Controllers;

use App\Models\RequirementCategory;
use Illuminate\Http\Request;

class RequirementCategoryController extends Controller
{
    public function index()
    {
        $categories = RequirementCategory::all();
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

        RequirementCategory::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Requirements category created successfully.');
    }

    public function show(RequirementCategory $category)
    {
        return view('requirements_categories.show', compact('category'));
    }

    public function edit(RequirementCategory $category)
    {
        return view('requirements_categories.edit', compact('category'));
    }

    public function update(Request $request, RequirementCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Requirements category updated successfully.');
    }

    public function destroy(RequirementCategory $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Requirements category deleted successfully.');
    }
}
