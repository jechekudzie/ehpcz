<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    public function index()
    {
        $professions = Profession::all();
        return view('professions.index', compact('professions'));
    }

    public function create()
    {
        return view('professions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'plural' => 'nullable|string|max:255',
            'certificate_expiry_month' => 'nullable|string|max:255',
        ]);

        Profession::create($request->all());

        return redirect()->route('professions.index')
            ->with('success', 'Profession created successfully.');
    }

    public function show(Profession $profession)
    {
        return view('professions.show', compact('profession'));
    }

    public function edit(Profession $profession)
    {
        return view('professions.edit', compact('profession'));
    }

    public function update(Request $request, Profession $profession)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'plural' => 'nullable|string|max:255',
            'certificate_expiry_month' => 'nullable|string|max:255',
        ]);

        $profession->update($request->all());

        return redirect()->route('professions.index')
            ->with('success', 'Profession updated successfully.');
    }

    public function destroy(Profession $profession)
    {
        $profession->delete();

        return redirect()->route('professions.index')
            ->with('success', 'Profession deleted successfully.');
    }
}
