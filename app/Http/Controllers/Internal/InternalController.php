<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Internal;

class InternalController extends Controller
{
    public function getUser()
    {
        $internals = Internal::with('roles')->paginate(15);

        return response()->json($internals);
    }


    public function findUser($id)
    {
        $internal = Internal::find($id);
        return response()->json(['data' => $internal]);
    }


    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $data = Internal::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        return response()->json(['data' => $data], 201);
    }


    public function updateUser($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = Internal::find($id);

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        $user->assignRole($request->role);

        return response()->json(['data' => $user]);
    }
}
