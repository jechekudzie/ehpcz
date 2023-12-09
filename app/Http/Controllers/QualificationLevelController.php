<?php

namespace App\Http\Controllers;

use App\Models\QualificationLevel;
use Illuminate\Http\Request;

class QualificationLevelController extends Controller
{
    public function index()
    {
        $levels = QualificationLevel::all();
        return view('qualification_levels.index', compact('levels'));
    }

    public function create()
    {
        return view('qualification_levels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        QualificationLevel::create($request->all());

        return redirect()->route('levels.index')
            ->with('success', 'Qualification level created successfully.');
    }

    public function show(QualificationLevel $level)
    {
        return view('qualification_levels.show', compact('level'));
    }

    public function edit(QualificationLevel $level)
    {
        return view('qualification_levels.edit', compact('level'));
    }

    public function update(Request $request, QualificationLevel $level)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $level->update($request->all());

        return redirect()->route('levels.index')
            ->with('success', 'Qualification level updated successfully.');
    }

    public function destroy(QualificationLevel $level)
    {
        $level->delete();

        return redirect()->route('levels.index')
            ->with('success', 'Qualification level deleted successfully.');
    }
}
