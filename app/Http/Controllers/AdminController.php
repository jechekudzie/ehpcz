<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    public function index()
    {
        return view('administration.index');
    }

    public function table()
    {
        return view('administration.table');
    }

    public function form()
    {
        return view('administration.form');
    }

    public function profile()
    {
        return view('administration.profile');
    }

    public function dashboard()
    {
        return view('administration.dashboard');
    }
    public function pickers()
    {
        return view('administration.pickers');
    }
}
