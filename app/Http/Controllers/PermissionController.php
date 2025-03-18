<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // This method will show permission page
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate(10);
        return view('permissions.index', compact('permissions'));
    }

    // This method will show create permission page
    public function create()
    {
        return view('permissions.create');
    }

    // This method will show insert a permission in DB
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3'
        ]);

        if ($validator->passes()) {
            Permission::create(['name' => $request->name]);

            return redirect()->route('permission.index')->with('success', 'Permission added successfully.');
        } else {
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    // This method will show edit permisison page
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }

    // This method will will update permisison 
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        // return $permission;

        $validator = Validator::make($request->all(), [
            'name' => "required|min:3|unique:permissions,id,$permission->id"
        ]);

        if ($validator->passes()) {
            $permission->update(['name' => $request->name]);

            return redirect()->route('permission.index')->with('success', 'Permission updated successfully.');
        } else {
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    // This method will will destroy permisison 
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        if ($permission !== null) {
            $permission->delete();
            return redirect()->back()->with('success', 'Permission deleted successfully.');
        }
    }
}
