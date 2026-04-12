@extends('layouts.app')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-body">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">List Kategori</h4>

            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                + Tambah
            </a>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table align-middle">

                <thead class="bg-dark text-white">
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Produk</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($categories as $cat)
                    <tr>

                        <td>{{ $cat->id }}</td>

                        <td class="fw-semibold">
                            {{ $cat->nama }}
                        </td>

                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $cat->products_count }} produk
                            </span>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('categories.edit', $cat->id) }}" 
                               class="btn btn-sm btn-warning">
                                ✏️
                            </a>

                            <form action="{{ route('categories.destroy', $cat->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    🗑️
                                </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection