@extends('layouts.app')

@section('content')
<h2>Tambah Kategori</h2>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf

    <input type="text" name="nama" class="form-control mb-2" placeholder="Nama kategori">

    <button class="btn btn-success">Simpan</button>
</form>
@endsection