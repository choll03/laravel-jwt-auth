<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;

class RoleController extends Controller
{
    private $guard = 'internal';

    public function getRole()
    {
        $roles = Role::paginate(15);

        return response()->json($roles);
    }


    public function findRole($id)
    {
        $role = Role::find($id);
        return response()->json(['data' => $role]);
    }


    public function createRole(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $data = Role::create([
                'name'          => $request->name,
                'guard_name'    => $this->guard
            ]);
    
            return response()->json(['data' => $data], 201);

        } catch (\Exception $e) {
            return $this->alreadyExists($e);
        } 
    }


    public function updateRole($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = Role::find($id);

        $data->update([
            'name'      => $request->name,
        ]);

        return response()->json(['data' => $data]);
    }


    private function alreadyExists(\Exception $e)
    {
        $message = '';

        if($e instanceof RoleAlreadyExists) {
            $message = 'Role sudah di buat';
        }

        else if($e instanceof PermissionAlreadyExists) {
            $message = 'Permission sudah di buat';
        }

        else {
            $message = 'Terjadi kesalahan';
        }

        return response()->json([
            'message' => $message
        ], 400);
    }
}
