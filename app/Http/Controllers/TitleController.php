<?php

namespace App\Http\Controllers;

use App\Models\Title;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function index()
    {
        $titles = Title::all();
        return view('titles.index', compact('titles'));
    }

    public function create()
    {
        return view('titles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Title::create($request->all());

        return redirect()->route('titles.index')
            ->with('success', 'Title created successfully.');
    }

    public function show(Title $title)
    {
        return view('titles.show', compact('title'));
    }

    public function edit(Title $title)
    {
        return view('titles.edit', compact('title'));
    }

    public function update(Request $request, Title $title)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $title->update($request->all());

        return redirect()->route('titles.index')
            ->with('success', 'Title updated successfully.');
    }

    public function destroy(Title $title)
    {
        $title->delete();

        return redirect()->route('titles.index')
            ->with('success', 'Title deleted successfully.');
    }
}
