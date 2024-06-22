<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    // cruds

    public function index()
    {
        $categories = Categories::all();
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category = new Categories();
        $category->name = $request->name;
        $category->save();

        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }

    // update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category = Categories::find($id);
        $category->name = $request->name;
        $category->save();

        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }

    // delete

    public function destroy($id)
    {
        $category = Categories::find($id);
        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted'
        ]);
    }

    // show

    public function show($id)
    {
        $category = Categories::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }
}
