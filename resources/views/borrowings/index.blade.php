@extends('layout.main')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <div>
                    <h1 class="m-0">Peminjaman</h1>
                </div><!-- /.col -->
                <div>
                    <a href="/borrows/add" class="bg-success btn">Tambah Peminjaman</a>
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
                        <th scope="col">Judul Buku</th>
                        <th scope="col">Nama Peminjam</th>
                        <th scope="col">Tanggal Pinjam</th>
                        <th scope="col">Tanggal Kembali</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $borrow) : ?> <tr>
                            <td><?= $borrow->books->title ?></td>
                            <td><?= $borrow->users->username ?></td>
                            <td><?= $borrow->borrowed_at ?></td>
                            <td><?= $borrow->returned_at ?></td>
                            <td class="d-flex">
                                <a href="{{ route('borrowings.edit', $borrow->id) }}" class="btn btn-primary">Edit</a>
                                <form class="px-2" action="{{ route('borrowings.destroy', $borrow->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus Penulis ini?')">Hapus</button>
                                </form>
                                <!-- returnbook -->
                                <form class="px-2" action="{{ route('borrowings.return', $borrow->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Kembalikan buku ini?')">Kembalikan</button>
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