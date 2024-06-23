<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\BooksBorrowings;
use App\Models\User;
use Illuminate\Http\Request;

class BorrowingsController extends Controller
{
    //index
    public function index()
    {
        $data = BooksBorrowings::all();

        return view('borrowings.index', compact('data'));
    }

    // create

    public function create()
    {
        $books = Books::all();
        $users = User::all(); // Pastikan ini sesuai dengan nama model peminjam Anda
        return view('borrowings.create', compact('books', 'users'));
    }

    // store

    public function store(Request $request)
    {
        $request->validate([
            'book_isbn' => 'required|exists:books,isbn', // Validasi bahwa book_id harus ada di tabel books
            'user_id' => 'required|exists:users,id', // Validasi bahwa borrower_id harus ada di tabel borrowers // Validasi tanggal pengembalian harus setelah tanggal peminjaman
        ]);

        $bookborrowings = new BooksBorrowings();
        $bookborrowings->book_id = $request->book_isbn;
        $bookborrowings->user_id = $request->user_id; // Simpan ID peminjam
        // use timestamp_current
        $bookborrowings->borrowed_at = now();
        $bookborrowings->save();

        return redirect()->route('borrowings.index')->with('success', 'Borrowing created successfully');
    }


    // edit

    public function edit($id)
    {
        $books = Books::all();
        $users = User::all();
        $borrowing = BooksBorrowings::findOrFail($id);

        return view('borrowings.edit', compact('borrowing', 'books', 'users'));
    }

    // update

    public function update(Request $request, $id)
    {
        $request->validate([
            'book_isbn' => 'required',
            "user_id" => "required",
        ]);

        $borrowing = BooksBorrowings::findOrFail($id);
        $borrowing->book_id = $request->book_isbn;
        $borrowing->user_id = $request->user_id;
        $borrowing->borrowed_at = now();
        $borrowing->save();

        return redirect()->route('borrowings.index')->with('success', 'Borrowing updated successfully');
    }

    // destroy

    public function destroy($id)
    {
        $borrowing = BooksBorrowings::findOrFail($id);
        $borrowing->delete();

        return redirect()->route('borrowings.index')->with('success', 'Borrowing deleted successfully');
    }

    // update return date
    public function returnBook($id)
    {
        $borrowing = BooksBorrowings::findOrFail($id);
        $borrowing->returned_at = now();
        $borrowing->save();

        return redirect()->route('borrowings.index')->with('success', 'Book returned successfully');
    }
}
