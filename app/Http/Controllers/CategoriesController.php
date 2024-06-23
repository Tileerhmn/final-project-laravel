<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //index
    public function index()
    {
        $data = Categories::all();

        return view('category.index', compact('data'));
    }

    // create

    public function create()
    {
        return view('category.create');
    }

    // store

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = new Categories();
        $category->name = $request->name;
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category created successfully');
    }


    // edit

    public function edit($id)
    {
        $category = Categories::findOrFail($id);

        return view('category.edit', compact('category'));
    }

    // update

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Categories::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category updated successfully');
    }

    // destroy

    public function destroy($id)
    {
        $category = Categories::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully');
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
