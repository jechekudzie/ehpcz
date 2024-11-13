<?php
namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Practitioner;
use App\Models\ProfessionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
    public function index(Election $election, ProfessionCategory $category)
    {
        // Fetch all candidates for this election and category
        //$candidates = $category->candidates()->where('election_id', $election->id)->get();

        // Fetch all candidates for this election and category
        $candidates = Candidate::where('profession_category_id', $category->id)
            ->where('election_id', $election->id)
            ->get();

        // Fetch all practitioners to list in the candidate form
        $allPractitioners = Practitioner::all();

        return view('elections.candidates.index', compact('election', 'category', 'candidates', 'allPractitioners'));
    }

    public function searchPractitioners(Request $request, Election $election, ProfessionCategory $category)
    {
        $query = $request->get('query');

        if (strlen($query) >= 3) {
            $search = '%' . $query . '%';

            // Search practitioners based on complex query conditions
            $practitioners = Practitioner::where(function ($q) use ($search) {
                $q->where('first_name', 'like', $search)
                    ->orWhere('last_name', 'like', $search)
                    ->orWhere('middle_name', 'like', $search)
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', middle_name, ' ', last_name)"), 'like', $search)
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', $search);
            })
                ->orWhereHas('practitionerProfessions', function ($q) use ($search) {
                    // Search by registration number in the practitioner_professions table
                    $q->where('registration_number', 'like', $search);
                })
                ->get();

            return response()->json($practitioners);
        }

        return response()->json([]);
    }



    public function store(Request $request, Election $election, ProfessionCategory $category)
    {
        $request->validate([
            'practitioner_id' => 'required|exists:practitioners,id',
        ]);

        // Check if the practitioner is already a candidate in this category and election
        $exists = Candidate::where('practitioner_id', $request->practitioner_id)
            ->where('profession_category_id', $category->id)
            ->where('election_id', $election->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['practitioner_id' => 'This practitioner is already a candidate in this category.']);
        }

        // Create the candidate
        Candidate::create([
            'practitioner_id' => $request->practitioner_id,
            'profession_category_id' => $category->id,
            'election_id' => $election->id,
            'status' => 'Running', // Default status
        ]);

        return redirect()->route('elections.categories.candidates.index', [$election->id, $category->id])
            ->with('success', 'Candidate added successfully.');
    }

    public function destroy(Election $election, ProfessionCategory $category, Candidate $candidate)
    {
        $candidate->delete();

        return redirect()->route('elections.categories.candidates.index', [$election->id, $category->id])
            ->with('success', 'Candidate removed successfully.');
    }
}
