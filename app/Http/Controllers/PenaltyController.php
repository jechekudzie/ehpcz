<?php

namespace App\Http\Controllers;

use App\Models\Penalty;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    //
    public function index()
    {
        $penalty = Penalty::find(1);

        return view('administration.penalty.index', compact('penalty'));
    }

    //store
    public function store(Request $request)
    {
        $penalty = new Penalty();
        $penalty->percentage = $request->percentage;
        $penalty->threshold = $request->threshold;
        $penalty->save();

        return redirect()->route('penalties.index')->with('success', 'Penalty created successfully');
    }

    //update
    public function update(Request $request, Penalty $penalty)
    {
        $penalty->percentage = $request->percentage;
        $penalty->threshold = $request->threshold;
        $penalty->save();

        return redirect()->route('penalties.index')->with('success', 'Penalty updated successfully');
    }

    //destroy
    public function destroy(Penalty $penalty)
    {
        $penalty->delete();

        return redirect()->route('penalties.index')->with('success', 'Penalty deleted successfully');
    }
}
