<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\ElectionGroup;
use App\Models\Practitioner;
use App\Models\Vote;
use App\Models\PractitionerProfession;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ElectionVotingController extends Controller
{
    //index page
    public function index()
    {
        // Try to get the latest election, or return null if none exist
        $election = Election::latest()->first();

        // Pass null to the view if no election is found
        return view('elections.voting.index', compact('election'));
    }

    public function results()
    {
        // Get the latest election
        $election = Election::latest()->first();

        // Initialize groups as an empty array
        $groups = [];
        if (auth()->check()) {
            // Check if the logged-in user has the role 'admin', 'minister', or 'super-admin'
            if (auth()->user()->hasAnyRole(['admin', 'minister', 'super-admin'])) {
                // Admin, Minister, or Super-Admin can view results regardless of election status
                $groups = $election->electionGroups()->with([
                    'categories.candidates.votes',
                    'categories.candidates.practitioner'
                ])->get();
            } else {
                // Regular authenticated users can only view results if the election is completed
                if ($election->status == 'Completed') {
                    $groups = $election->electionGroups()->with([
                        'categories.candidates.votes',
                        'categories.candidates.practitioner'
                    ])->get();
                } else {
                    // Prevent access if election is not completed
                    $groups = null;
                }
            }
        } else {
            // For unauthenticated users, check election status
            if ($election->status == 'Completed') {
                $groups = $election->electionGroups()->with([
                    'categories.candidates.votes',
                    'categories.candidates.practitioner'
                ])->get();
            } else {
                // If the election is not completed, prevent access
                $groups = [];
            }
        }

        // Return the results view with election and groups data
        return view('elections.results.index', compact('election', 'groups'));
    }

    //votersRoll
    public function votersRoll()
    {

        return view('elections.voting.voters_roll');
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


    public function getStatistics()
    {
        $latestElection = \App\Models\Election::latest()->first();

        if (!$latestElection) {
            return back()->with('error', 'No active election found.');
        }

        $groups = ElectionGroup::with('categories')->where('election_id', $latestElection->id)->get();

        $statistics = [];

        foreach ($groups as $group) {
            foreach ($group->categories as $category) {
                $totalPractitioners = PractitionerProfession::whereHas('profession', function($query) use ($group) {
                    $query->whereHas('electionGroups', function($q) use ($group) {
                        $q->where('election_groups.id', $group->id);
                    });
                })->count();

                $updatedPractitioners = Contact::where('contact_type_id', 1)
                    ->whereHas('practitioner.practitionerProfessions', function ($query) use ($category) {
                        $query->whereHas('profession', function($q) use ($category) {
                            $q->whereHas('electionGroups', function($eq) use ($category) {
                                $eq->where('election_groups.id', $category->group_id);
                            });
                        });
                    })->distinct('practitioner_id')->count();

                $votedPractitioners = Vote::where('election_id', $latestElection->id)
                    ->where('profession_category_id', $category->id)
                    ->distinct('practitioner_id')->count();

                $statistics[] = [
                    'group' => $group->name,
                    'category' => $category->name,
                    'total_practitioners' => $totalPractitioners,
                    'updated_practitioners' => $updatedPractitioners,
                    'voted_practitioners' => $votedPractitioners,
                ];
            }
        }

        return view('elections.voting.statistics', compact('statistics', 'latestElection'));
    }
}
