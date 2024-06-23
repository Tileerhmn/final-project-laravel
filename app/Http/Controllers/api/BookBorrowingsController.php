<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BooksBorrowings;
use Illuminate\Http\Request;

class BookBorrowingsController extends Controller
{
    public function index()
    {
        $borrowings = BooksBorrowings::with(['books', 'users'])->get();
        $data = $borrowings->map(function ($borrowing) {
            return [
                'id' => $borrowing->id,
                'book' => $borrowing->books->title,
                'user' => $borrowing->users->username,
                'borrowed_at' => $borrowing->borrowed_at,
                'returned_at' => $borrowing->returned_at
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }


    public function show($id)
    {
        $borrowing = BooksBorrowings::with(['books', 'users'])->find($id); // Eager loading relasi book dan user
        if (!$borrowing) {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
        }

        // data yang akan dikembalikan
        $data = [
            'id' => $borrowing->id,
            'book' => $borrowing->books->title,
            'isbn' => $borrowing->books->isbn,
            "user_id" => $borrowing->users->id,
            'user' => $borrowing->users->username,
            'borrowed_at' => $borrowing->borrowed_at,
            'returned_at' => $borrowing->returned_at
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $borrowing = BooksBorrowings::find($id);

        if (!$borrowing) {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
        }

        $request->validate([
            'book_id' => 'sometimes|exists:books,isbn', // Validasi isbn jika diubah
            'user_id' => 'sometimes|exists:users,id', // Validasi id user jika diubah
        ]);

        if ($request->has('book_id')) {
            $borrowing->book_id = $request->book_id;
        }

        if ($request->has('user_id')) {
            $borrowing->user_id = $request->user_id;
        }

        $borrowing->save();

        return response()->json([
            'status' => 'success',
            'data' => $borrowing
        ]);
    }

    public function destroy($id)
    {
        $borrowing = BooksBorrowings::find($id);

        if (!$borrowing) {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
        }

        $borrowing->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Peminjaman berhasil dihapus'
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,isbn', // Pastikan isbn yang dimasukkan valid
            'user_id' => 'required|exists:users,id', // Pastikan id user yang dimasukkan valid
        ]);

        $borrowing = new BooksBorrowings();
        $borrowing->book_id = $request->book_id;
        $borrowing->user_id = $request->user_id;
        $borrowing->borrowed_at = now(); // Tanggal pinjam saat ini
        $borrowing->save();

        return response()->json([
            'status' => 'success',
            'data' => $borrowing
        ]);
    }

    public function returnBook($id)
    {
        $borrowing = BooksBorrowings::find($id);

        if (!$borrowing) {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
        }

        $borrowing->returned_at = now(); // Tanggal kembali saat ini
        $borrowing->save();

        return response()->json([
            'status' => 'success',
            'data' => $borrowing
        ]);
    }
}
