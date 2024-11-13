<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\ElectionGroup;
use App\Models\Practitioner;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ElectionVotingController extends Controller
{
    //index page
    public function index()
    {
        //get the latest election
        $election = Election::latest()->first();


        //get session practitioner_id
       // $practitioner_id = session('practitioner_id');
        //dd($practitioner_id);


        return view('elections.voting.index',compact('election'));
    }


    public function simulateVotes()
    {
        $practitioners = Practitioner::with('practitionerProfessions.profession')->get();

        foreach ($practitioners as $practitioner) {
            // Ensure we retrieve the registration number from the first profession (or skip if unavailable)
            $practitionerProfession = $practitioner->practitionerProfessions->first();

            if (!$practitionerProfession || !$practitionerProfession->registration_number) {
                // Skip this practitioner if there's no profession or registration number
                continue;
            }

            $registrationNumber = $practitionerProfession->registration_number;

            // Get practitioner's primary profession ID for matching
            $professionId = $practitionerProfession->profession_id;

            // Find eligible ElectionGroups for practitioner's profession
            $eligibleGroups = ElectionGroup::whereHas('professions', function ($query) use ($professionId) {
                $query->where('professions.id', $professionId);
            })->with(['categories.candidates'])->get();

            foreach ($eligibleGroups as $group) {
                foreach ($group->categories as $category) {
                    // Retrieve candidates in this category who share the practitioner's profession
                    $candidates = $category->candidates()->whereHas('practitioner.practitionerProfessions', function ($query) use ($professionId) {
                        $query->where('profession_id', $professionId);
                    })->get();

                    if ($candidates->isEmpty()) {
                        continue;
                    }

                    // Select a random candidate from the list
                    $candidate = $candidates->random();

                    // Check if the practitioner has already voted in this category
                    $existingVote = Vote::where([
                        'practitioner_id' => $practitioner->id,
                        'profession_category_id' => $category->id,
                        'election_id' => $group->election_id,
                    ])->first();

                    if ($existingVote) {
                        // Update the existing vote with the new candidate
                        $existingVote->update([
                            'candidate_id' => $candidate->id,
                            'registration_number' => $registrationNumber,
                        ]);
                    } else {
                        // Create a new vote record if none exists
                        Vote::create([
                            'practitioner_id' => $practitioner->id,
                            'election_id' => $group->election_id,
                            'profession_category_id' => $category->id,
                            'candidate_id' => $candidate->id,
                            'registration_number' => $registrationNumber,
                        ]);
                    }
                }
            }
        }
    }


    public function results()
    {
        $election = Election::latest()->first();
        // Load election groups and associated data for the specified election
        $groups = $election->electionGroups()->with([
            'categories.candidates.votes',
            'categories.candidates.practitioner'
        ])->get();

        // Debug the data structure
        //dd($groups);

        return view('elections.results.index', compact('election', 'groups'));
    }


}
