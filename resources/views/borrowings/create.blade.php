@extends('layout.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <div>
                    <h1 class="m-0">Store Peminjaman</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Peminjaman Buku</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('borrowings.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="book_isbn">Buku</label>
                            <select class="form-control" id="book_isbn" name="book_isbn" required>
                                <option value="">Pilih Buku</option>
                                @foreach($books as $book)
                                <option value="{{ $book->isbn }}">{{ $book->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user_id">Peminjam</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="">Pilih Peminjam</option>
                                @foreach($users as $borrower)
                                <option value="{{ $borrower->id }}">{{ $borrower->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection