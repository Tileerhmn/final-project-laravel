<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\Authors;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $data = Books::all();

        return view('book.index', compact('data'));
    }

    // create
    public function create()
    {
        $categories = Categories::all();
        $authors = Authors::all();
        return view('book.create', compact('categories', 'authors'));
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required|unique:books,isbn',
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
            'description' => 'required',
            'category_id' => 'required',
            'author_id' => 'required'
        ]);

        // Simpan gambar ke direktori storage
        $image = $request->file('image');
        $imageName = $request->isbn . '.' . $image->extension();
        $image->storeAs('public/book_images', $imageName);

        // Buat objek buku dan simpan ke database
        $book = new Books();
        $book->isbn = $request->isbn;
        $book->title = $request->title;
        $book->image = 'storage/book_images/' . $imageName; // Path gambar di dalam storage
        $book->description = $request->description;
        $book->category_id = $request->category_id;
        $book->author_id = $request->author_id;
        $book->save();

        return redirect()->route('book.index')->with('success', 'Book created successfully');
    }

    public function edit($id)
    {
        $book = Books::findOrFail($id);
        $categories = Categories::all();
        $authors = Authors::all();
        return view('book.edit', compact('book', 'categories', 'authors'));
    }

    public function update(Request $request, $isbn)
    {
        $request->validate([
            'isbn' => 'required|unique:books,isbn,' . $isbn . ',isbn',
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
            'category_id' => 'required',
            'author_id' => 'required'
        ]);

        $book = Books::findOrFail($isbn);

        // Update book data
        $book->isbn = $request->isbn;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->category_id = $request->category_id;
        $book->author_id = $request->author_id;

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete previous image if exists
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }

            // Store new image
            $imageName = $request->isbn . '.' . $request->file('image')->extension();
            $imagePath = $request->file('image')->storeAs('public/book_images', $imageName);
            $book->image = 'storage/book_images/' . $imageName;
        }

        $book->save();

        return redirect()->route('book.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy($isbn)
    {
        try {
            $book = Books::where('isbn', $isbn)->firstOrFail();

            // Hapus buku dari database
            $book->delete();

            return redirect()->route('book.index')->with('success', 'Buku berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withError('Tidak dapat menghapus buku karena masih memiliki relasi.');
        }
    }
}
