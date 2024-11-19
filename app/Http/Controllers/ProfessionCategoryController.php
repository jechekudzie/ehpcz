<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\ElectionGroup;
use App\Models\ProfessionCategory;
use Illuminate\Http\Request;

class ProfessionCategoryController extends Controller
{
    //
    public function index(Election $election, ElectionGroup $group)
    {
        // Get all categories associated with this group
        $categories = $group->categories;

        return view('elections.election_group_categories.index', compact('election', 'group', 'categories'));
    }

    public function store(Request $request, Election $election, ElectionGroup $group)
    {
        $request->validate([
            'name' => 'required|in:Local Authority,Non-Local Authority,General',
        ]);

        // Check if this category already exists in this group
        $exists = ProfessionCategory::where('group_id', $group->id)->where('name', $request->name)->exists();
        if ($exists) {
            return redirect()->back()->withErrors(['name' => 'This category is already added to the group.']);
        }

        // Create the new category
        ProfessionCategory::create([
            'group_id' => $group->id,
            'name' => $request->name,
        ]);

        return redirect()->route('elections.groups.categories.index', [$election->id, $group->id])
            ->with('success', 'Category added successfully.');
    }
}
