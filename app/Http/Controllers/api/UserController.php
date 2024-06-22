<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //index
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->role = 'user';
        $user->save();

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
}
