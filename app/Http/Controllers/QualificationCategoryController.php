<?php

namespace App\Http\Controllers;

use App\Models\QualificationCategory;
use Illuminate\Http\Request;

class QualificationCategoryController extends Controller
{
    public function index()
    {
        $categories = QualificationCategory::all();
        return view('qualification_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('qualification_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        QualificationCategory::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Qualification category created successfully.');
    }

    public function show(QualificationCategory $category)
    {
        return view('qualification_categories.show', compact('category'));
    }

    public function edit(QualificationCategory $category)
    {
        return view('qualification_categories.edit', compact('category'));
    }

    public function update(Request $request, QualificationCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Qualification category updated successfully.');
    }

    public function destroy(QualificationCategory $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Qualification category deleted successfully.');
    }
}
