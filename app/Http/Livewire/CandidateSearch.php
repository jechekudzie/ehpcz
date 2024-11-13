<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Practitioner;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\ProfessionCategory;
use Illuminate\Support\Facades\DB;

class CandidateSearch extends Component
{
    public $search = '';
    public $election;
    public $category;

    // Messages
    public $successMessage;
    public $errorMessage;

    protected $listeners = ['candidateAdded' => 'refreshCandidates'];

    public function mount(Election $election, ProfessionCategory $category)
    {
        $this->election = $election;
        $this->category = $category;
    }

    public function render()
    {
        $practitioners = collect();

        if (strlen($this->search) >= 3) {
            $search = '%' . $this->search . '%';

            // Fetch profession IDs associated with the group
            $groupProfessionIds = $this->category->group->professions->pluck('id')->toArray();

            if (!empty($groupProfessionIds)) {
                $query = Practitioner::query();

                // Apply search filters for name fields
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', $search)
                        ->orWhere('last_name', 'like', $search)
                        ->orWhere('middle_name', 'like', $search)
                        ->orWhere(DB::raw("CONCAT(first_name, ' ', middle_name, ' ', last_name)"), 'like', $search)
                        ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', $search);
                });

                // Filter practitioners with professions in the group
                $query->whereHas('practitionerProfessions', function ($q) use ($groupProfessionIds, $search) {
                    $q->whereIn('profession_id', $groupProfessionIds)
                        ->orWhere('registration_number', 'like', $search);
                });

                $practitioners = $query->limit(10)->get();
            }
        }

        return view('livewire.candidate-search', [
            'practitioners' => $practitioners
        ]);
    }

    public function addCandidate($practitionerId)
    {
        // Check if candidate is already registered in the election across any ElectionGroup or ProfessionCategory
        $existsInElection = Candidate::where('practitioner_id', $practitionerId)
            ->where('election_id', $this->election->id)
            ->exists();

        if ($existsInElection) {
            $this->errorMessage = 'This candidate is already registered in this election, either in the same or another group/category.';
            $this->successMessage = null;
        } else {
            // Add candidate as they are not registered in this election
            Candidate::create([
                'practitioner_id' => $practitionerId,
                'profession_category_id' => $this->category->id,
                'election_id' => $this->election->id,
                'status' => 'Running',
            ]);

            $this->successMessage = 'Candidate successfully added to the election!';
            $this->errorMessage = null;

            // Emit event to refresh the candidate list dynamically
            $this->emit('candidateAdded');
        }

        // Clear search field and messages
        $this->search = '';
    }

    public function refreshCandidates()
    {
        $this->render();
    }
}
