@extends('layout.main')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <div>
                    <h1 class="m-0">Buku</h1>
                </div><!-- /.col -->
                <div>
                    <a href="/book/add" class="bg-success btn">Tambah Buku</a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Gambar</th>
                        <th scope="col">Judul</th>
                        <th scope="col">deskripsi</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $book) : ?> <tr>
                            <td><img src="{{ asset($book->image) }}" alt="" style="width: 100px;"></td>
                            <td><?= $book->title ?></td>
                            <td><?= $book->description ?></td>
                            <td><?= $book->authors->name ?></td>
                            <td><?= $book->categories->name ?></td>
                            <td class="d-flex">
                                <a href="{{ route('book.edit', $book->isbn) }}" class="btn btn-primary">Edit</a>
                                <form class="px-2" action="{{ route('book.destroy', $book->isbn) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus buku ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

@endsection