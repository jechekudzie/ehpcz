<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\ElectionGroup;
use App\Models\ElectionGroupProfession;
use App\Models\Profession;
use Illuminate\Http\Request;

class ElectionGroupProfessionController extends Controller
{
    public function index(Election $election, ElectionGroup $group)
    {
        // Get all professions not yet assigned to any group in this election
        $assignedProfessionIds = ElectionGroupProfession::whereHas('group', function ($query) use ($election) {
            $query->where('election_id', $election->id);
        })->pluck('profession_id')->toArray();

        $allProfessions = Profession::whereNotIn('id', $assignedProfessionIds)->get();

        $assignedProfessions = $group->professions;

        return view('elections.election_group_professions.index', compact('election', 'group', 'allProfessions', 'assignedProfessions'));
    }



    public function store(Request $request, $electionId, $groupId)
    {
        $request->validate([
            'profession_id' => 'required|exists:professions,id',
        ]);

        $professionId = $request->input('profession_id');

        // Check if the profession is already assigned to any group in the same election
        $isAlreadyAssigned = ElectionGroupProfession::whereHas('group', function ($query) use ($electionId) {
            $query->where('election_id', $electionId);
        })->where('profession_id', $professionId)->exists();

        if ($isAlreadyAssigned) {
            return redirect()->back()->withErrors(['profession_id' => 'This profession is already assigned to a group in this election.']);
        }

        // If not assigned, create the association
        ElectionGroupProfession::create([
            'group_id' => $groupId,
            'profession_id' => $professionId,
        ]);

        return redirect()->route('elections.groups.professions.index', [$electionId, $groupId])
            ->with('success', 'Profession added to group successfully.');
    }


    public function destroy($electionId, $groupId, $professionId)
    {
        // Find the profession association in the group and delete it
        $professionAssignment = ElectionGroupProfession::where('group_id', $groupId)
            ->where('profession_id', $professionId)
            ->first();

        if ($professionAssignment) {
            $professionAssignment->delete();
            return redirect()->route('elections.groups.professions.index', [$electionId, $groupId])
                ->with('success', 'Profession removed from group successfully.');
        }

        return redirect()->route('elections.groups.professions.index', [$electionId, $groupId])
            ->withErrors(['error' => 'Profession not found in the group.']);
    }

}
