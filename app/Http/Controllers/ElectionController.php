<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    //
    public function index()
    {
        $elections = Election::all();
        return view('elections.election.index', compact('elections'));
    }

    // Show form for creating a new election
    public function create()
    {
        return view('elections.election.create');
    }

    // Store a new election
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Election::create($request->all());
        return redirect()->route('elections.index')->with('success', 'Election created successfully.');
    }

    // Show a single election
    public function show(Election $election)
    {
        return view('elections.election.show', compact('election'));
    }

    // Show form for editing an election
    public function edit(Election $election)
    {
        return view('elections.election.edit', compact('election'));
    }

    // Update an election
    public function update(Request $request, Election $election)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $election->update($request->all());
        return redirect()->route('elections.index')->with('success', 'Election updated successfully.');
    }

    // Delete an election
    public function destroy(Election $election)
    {
        $election->delete();
        return redirect()->route('elections.index')->with('success', 'Election deleted successfully.');
    }

}
