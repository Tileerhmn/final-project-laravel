<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //index
    public function index()
    {
        $data = User::where('role', 'user')->get();
        return view('user.index', compact('data'));
    }

    // create

    public function create()
    {
        return view('user.create');
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

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    // edit

    public function edit($id)
    {
        $data = User::find($id);
        return view('user.edit', compact('data'));
    }

    // update

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::find($id);
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->role = 'user';
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }


    // destroy

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('user.index')->with('success', 'User deleted successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check if the error is a foreign key constraint violation
            if ($e->getCode() == '23000') {
                return redirect()->route('user.index')->with('error', 'Cannot delete user because it is associated with other records.');
            } else {
                return redirect()->route('user.index')->with('error', 'An unexpected error occurred.');
            }
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 'An unexpected error occurred.');
        }
    }
}
