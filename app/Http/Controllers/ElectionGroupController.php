<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\ElectionGroup;
use Illuminate\Http\Request;

class ElectionGroupController extends Controller
{
// Display a listing of the groups for a specific election
    public function index(Election $election)
    {
        $groups = $election->electionGroups; // Retrieve all groups associated with the election
        return view('elections.election_groups.index', compact('election', 'groups'));
    }

// Show the form for creating a new group
    public function create(Election $election)
    {
        return view('elections.election_groups.create', compact('election'));
    }

// Store a newly created group in storage
    public function store(Request $request, Election $election)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $election->electionGroups()->create($request->all());

        return redirect()->route('elections.groups.index', $election->id)
            ->with('success', 'Election group created successfully.');
    }

// Show the form for editing the specified group
    public function edit(ElectionGroup $group)
    {
        $election = $group->election; // Get the related election for this group
        return view('elections.election_groups.edit', compact('group', 'election'));
    }

// Update the specified group in storage
    public function update(Request $request, ElectionGroup $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group->update($request->all());

        return redirect()->route('elections.groups.index', $group->election_id)
            ->with('success', 'Election group updated successfully.');
    }

// Remove the specified group from storage
    public function destroy(ElectionGroup $group)
    {
        $group->delete();

        return redirect()->route('elections.groups.index', $group->election_id)
            ->with('success', 'Election group deleted successfully.');
    }
}
