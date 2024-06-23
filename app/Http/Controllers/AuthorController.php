<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use App\Models\Books;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    //index
    public function index()
    {
        $data = Authors::all();

        return view('authors.index', compact('data'));
    }

    // create
    public function create()
    {
        return view('authors.create');
    }

    // store

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:authors,email',
        ]);

        $author = new Authors();
        $author->name = $request->name;
        $author->email = $request->email;
        $author->save();

        return redirect()->route('authors.index')->with('success', 'Author created successfully');
    }

    // edit

    public function edit($id)
    {
        $author = Authors::findOrFail($id);

        return view('authors.edit', compact('author'));
    }

    // update

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:authors,email,' . $id,
        ]);

        $author = Authors::findOrFail($id);
        $author->name = $request->name;
        $author->email = $request->email;
        $author->save();

        return redirect()->route('authors.index')->with('success', 'Author updated successfully');
    }

    // destroy

    public function destroy($id)
    {
        $author = Authors::findOrFail($id);

        // Cek apakah ada buku yang menggunakan author yang akan dihapus
        $booksUsingAuthor = Books::where('author_id', $author->id)->exists();

        if ($booksUsingAuthor) {
            return redirect()->route('authors.index')->with('error', 'Tidak dapat menghapus author karena masih ada buku yang menggunakan author ini.');
        }

        // Jika tidak ada buku yang menggunakan author, lanjutkan dengan penghapusan
        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Author deleted successfully');
    }
}
