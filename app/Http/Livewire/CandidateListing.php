<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Election;
use App\Models\ElectionGroup;
use App\Models\Candidate;
use Illuminate\Support\Facades\Session;

class CandidateListing extends Component
{
    public $election;
    public $groups;
    public $successMessage;
    public $errorMessage;
    public $selectedCandidateId;

    public $practitionerVotes = [];



    public function mount(Election $election)
    {
        $this->election = $election;
        Session::put('current_election_id', $election->id); // Store election ID for login redirection
        $this->loadCandidates();

        // If a practitioner is logged in, get their votes
        if (Session::has('practitioner_id')) {
            $this->loadPractitionerVotes();
        }
    }

    public function loadPractitionerVotes()
    {
        $practitionerId = Session::get('practitioner_id');
        $this->practitionerVotes = \App\Models\Vote::where('practitioner_id', $practitionerId)
            ->pluck('candidate_id')
            ->toArray();
    }


    public function loadCandidates()
    {
        $this->groups = ElectionGroup::with([
            'categories.candidates.practitioner.practitionerProfessions.profession'
        ])
            ->where('election_id', $this->election->id)
            ->get();
    }

    public function vote($candidateId)
    {
        if (!Session::has('practitioner_id')) {
            return redirect()->route('voting.login')->with('error', 'Please log in to vote.');
        }

        $practitionerId = Session::get('practitioner_id');
        $candidate = Candidate::findOrFail($candidateId);

        // Retrieve the candidate's profession category and election group
        $professionCategory = $candidate->category;
        $electionGroup = $professionCategory->group;

        if (!$electionGroup) {
            $this->errorMessage = 'The candidate is not associated with a valid election group.';
            return;
        }

        // Get practitioner's profession IDs
        $practitionerProfessions = \App\Models\Practitioner::find($practitionerId)
            ->practitionerProfessions->pluck('profession_id')->toArray();

        // Check if practitioner's professions overlap with the professions in the candidate's election group
        $matchingProfessions = $electionGroup->professions->whereIn('id', $practitionerProfessions);

        if ($matchingProfessions->isEmpty()) {
            $this->errorMessage = 'You can only vote for candidates whose election group matches your profession.';
            $this->emit('error', $this->errorMessage);
            return;
        }

        // Check if the practitioner has already voted in this category and election
        $existingVote = \App\Models\Vote::where('practitioner_id', $practitionerId)
            ->where('election_id', $candidate->election_id)
            ->where('profession_category_id', $professionCategory->id)
            ->first();

        if ($existingVote) {
            // Update the existing vote with the new candidate_id
            $existingVote->update([
                'candidate_id' => $candidateId
            ]);
            $this->successMessage = 'Your vote has been updated to the selected candidate!';

            $this->emit('votingSuccess', $this->successMessage);
        } else {
            // If no previous vote, create a new one
            $practitionerProfession = $candidate->practitioner->practitionerProfessions->first();
            $registrationNumber = $practitionerProfession->registration_number ?? 'N/A';

            \App\Models\Vote::create([
                'practitioner_id' => $practitionerId,
                'election_id' => $candidate->election_id,
                'profession_category_id' => $professionCategory->id,
                'candidate_id' => $candidateId,
                'registration_number' => $registrationNumber
            ]);
            $this->successMessage = 'Your vote has been recorded for the selected candidate!';
            $this->emit('votingSuccess', $this->successMessage);
        }
        // Refresh the practitioner's votes after voting
        $this->loadPractitionerVotes();
    }


    public function render()
    {
        return view('livewire.candidate-listing', [
            'groups' => $this->groups,
            'practitionerVotes' => $this->practitionerVotes
        ]);
    }
}
