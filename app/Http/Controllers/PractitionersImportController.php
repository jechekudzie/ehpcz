<?php

namespace App\Http\Controllers;

use App\Models\Practitioner;
use Illuminate\Http\Request;
use App\Imports\PractitionersImport;
use Maatwebsite\Excel\Facades\Excel;

class PractitionersImportController extends Controller
{
    //Index
    public function index()
    {
        $practitioners = Practitioner::all();
        return view('administration.import.index',compact('practitioners'));
    }


    public function store(Request $request)
    {
        Excel::import(new PractitionersImport, $request->file('file'));

        return back()->with('success', 'Data imported successfully');
    }
}
