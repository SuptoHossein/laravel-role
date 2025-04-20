<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    // This method will show Role page
    public function index()
    {
        $roles = Role::orderBy('name', 'ASC')->paginate(10);
        return view("roles.index", compact("roles"));
    }

    // This method will show create role page
    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.create', compact('permissions'));
    }

    // This method will show insert a role in DB
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3'
        ]);

        if ($validator->passes()) {
            $role = Role::create(['name' => $request->name]);

            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }

            return redirect()->route('role.index')->with('success', 'Role added successfully.');
        } else {
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    // This method will show edit permisison page
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('roles.edit', compact('role', 'hasPermissions', 'permissions', 'role'));
    }

    // This method will will update permisison 
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        // return $permission;

        $validator = Validator::make($request->all(), [
            'name' => "required|min:3|unique:roles,id,$role->id"
        ]);

        if ($validator->passes()) {
            $role->update(['name' => $request->name]);

            if (!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]);
            }

            return redirect()->route('role.index')->with('success', 'Role updated successfully.');
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
