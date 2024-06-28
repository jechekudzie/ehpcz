<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    //index
    public function index()
    {
        $modules = Module::all()->sortBy('id');
        $permissions = Permission::all();
        $roles = Role::all();
        return view('administration.roles.index', compact('modules', 'permissions','roles'));

    }

    //store
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:roles',
        ]);
        $role = Role::create(['name' => strtolower($request->name)]);

        return redirect()->route('roles.index');
    }

    //update
    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        $role->update(['name' => strtolower($request->name)]);

        return redirect()->route('roles.index');
    }
}
