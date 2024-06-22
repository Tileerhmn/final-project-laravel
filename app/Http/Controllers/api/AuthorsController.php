<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Authors;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    //crud

    public function index()
    {
        $authors = Authors::all();
        return response()->json([
            'status' => 'success',
            'data' => $authors
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:authors,email'
        ]);

        $author = new Authors();
        $author->name = $request->name;
        $author->email = $request->email;
        $author->save();

        return response()->json([
            'status' => 'success',
            'data' => $author
        ]);
    }

    // update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:authors,email'
        ]);

        $author = Authors::find($id);
        $author->name = $request->name;
        $author->email = $request->email;
        $author->save();

        return response()->json([
            'status' => 'success',
            'data' => $author
        ]);
    }

    // delete

    public function destroy($id)
    {
        $author = Authors::find($id);
        $author->delete();

        return response()->json([
            'status' => 'success',
            'data' => $author
        ]);
    }
}
