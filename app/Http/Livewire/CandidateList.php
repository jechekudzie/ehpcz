<?php
namespace App\Http\Livewire;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\ProfessionCategory;
use Livewire\Component;

class CandidateList extends Component
{
    public $election;
    public $category;

    protected $listeners = ['candidateAdded' => 'refreshList'];

    public function mount(Election $election, ProfessionCategory $category)
    {
        $this->election = $election;
        $this->category = $category;
    }

    public function refreshList()
    {
        // This method will be called when a new candidate is added
    }

    public function render()
    {
        $candidates = Candidate::with('practitioner.practitionerProfessions')
            ->where('election_id', $this->election->id)
            ->where('profession_category_id', $this->category->id)
            ->get();

        return view('livewire.candidate-list', compact('candidates'));
    }
}
