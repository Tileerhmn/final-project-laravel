<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    //crud

    public function index()
    {
        $books = Books::all();
        return response()->json([
            'status' => 'success',
            'data' => $books
        ]);
    }

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
        Storage::putFileAs('public/book_images', $image, $imageName);

        // Buat objek buku dan simpan ke database
        $book = new Books();
        $book->isbn = $request->isbn;
        $book->title = $request->title;
        $book->image = 'storage/book_images/' . $imageName; // Path gambar di dalam storage
        $book->description = $request->description;
        $book->category_id = $request->category_id;
        $book->author_id = $request->author_id;
        $book->save();

        return response()->json([
            'status' => 'success',
            'data' => $book
        ]);
    }


    // update
    public function update(Request $request, $isbn)
    {
        $book = Books::find($isbn);

        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        // Validasi input
        $request->validate([
            'title' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar jika ada perubahan
            'description' => 'required',
            'category_id' => 'required',
            'author_id' => 'required',
        ]);

        // Update data buku
        $book->title = $request->title;
        $book->description = $request->description;
        $book->category_id = $request->category_id;
        $book->author_id = $request->author_id;

        // Mengelola gambar jika ada perubahan
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if (Storage::exists($book->image)) {
                Storage::delete($book->image);
            }

            // Simpan gambar baru ke storage
            $image = $request->file('image');
            $imageName = $request->isbn . '.' . $image->extension();
            Storage::putFileAs('public/book_images', $image, $imageName);
            $book->image = 'storage/book_images/' . $imageName;
        }

        $book->save();

        return response()->json([
            'status' => 'success',
            'data' => $book
        ]);
    }

    // delete

    public function destroy($id)
    {
        $book = Books::find($id);
        $book->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Book deleted'
        ]);
    }

    // show

    public function show($id)
    {
        $book = Books::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $book
        ]);
    }

    // search

    public function search(Request $request)
    {
        $books = Books::where('title', 'like', '%' . $request->title . '%')->get();
        return response()->json([
            'status' => 'success',
            'data' => $books
        ]);
    }
}
