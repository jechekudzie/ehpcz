<?php

namespace App\Http\Livewire\Practitioners;

use App\Models\Practitioner;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];

    public function updatingSearch()
    {
        $this->resetPage();  // Reset pagination to the first page
    }


    public function deletePractitioner($practitionerId)
    {
        $practitioner = Practitioner::findOrFail($practitionerId);

        // Deleting related records
        if ($practitioner->practitionerIdentifications()->exists()) {
            $practitioner->practitionerIdentifications()->delete();
        }
        if ($practitioner->contacts()->exists()) {
            $practitioner->contacts()->delete();
        }
        if ($practitioner->addresses()->exists()) {
            $practitioner->addresses()->delete();
        }
        if ($practitioner->employments()->exists()) {
            $practitioner->employments()->delete();
        }
        if ($practitioner->practitionerProfessions()->exists()) {
            $practitioner->practitionerProfessions()->delete();
        }
        if ($practitioner->renewals()->exists()) {
            $practitioner->renewals()->delete();
        }
        if ($practitioner->payments()->exists()) {
            $practitioner->payments()->delete();
        }

        // Finally delete practitioner
        $practitioner->delete();

        session()->flash('success', 'Practitioner deleted successfully.');
    }




    public function render()
    {
        $query = Practitioner::query();

        if (strlen($this->search) >= 3) {
            $search = '%' . $this->search . '%';

            // Search by name or registration number
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', $search)
                    ->orWhere('last_name', 'like', $search)
                    ->orWhere('middle_name', 'like', $search)
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', middle_name, ' ', last_name)"), 'like', $search)
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', $search);
            })
                ->orWhereHas('practitionerProfessions', function ($q) use ($search) {
                    // Search by registration number in the practitioner_professions table
                    $q->where('registration_number', 'like', $search);
                });
        }
        // Add sorting by first_name and last_name
        $practitioners = $query->orderBy('first_name')
            ->orderBy('last_name')
            ->paginate(12);


        return view('livewire.practitioners.index', compact('practitioners'));
    }
}
