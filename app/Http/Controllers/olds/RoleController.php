<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'role_name' => 'required',
            'role' => 'required',
        ]);
        $new_role = Role::create(
            $request->role_name,
            $request->role
        );
        
        return response()->json($new_role, 200);
    }

    public function remove(Request $request)
    {
        $id = $request->role_id;
        
        $role = Role::find($id);
        if($role) {
            $role->delete();
            return response()->json('success', 200);
        }
        else {
            return response()->json(['error' => 'Not found'], 404);
        }
    }

    public function list()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}
