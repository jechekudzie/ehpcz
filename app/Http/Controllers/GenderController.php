<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    public function index()
    {
        $genders = Gender::all();
        return view('genders.index', compact('genders'));
    }

    public function create()
    {
        return view('genders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Gender::create($request->all());

        return redirect()->route('genders.index')
            ->with('success', 'Gender created successfully.');
    }

    public function show(Gender $gender)
    {
        return view('genders.show', compact('gender'));
    }

    public function edit(Gender $gender)
    {
        return view('genders.edit', compact('gender'));
    }

    public function update(Request $request, Gender $gender)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $gender->update($request->all());

        return redirect()->route('genders.index')
            ->with('success', 'Gender updated successfully.');
    }

    public function destroy(Gender $gender)
    {
        $gender->delete();

        return redirect()->route('genders.index')
            ->with('success', 'Gender deleted successfully.');
    }
}
