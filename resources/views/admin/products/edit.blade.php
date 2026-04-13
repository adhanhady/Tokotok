@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="fw-bold mb-4">Edit Produk</h3>

    <form action="{{ route('products.update', $product->id) }}" 
          method="POST" 
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <!-- NAMA -->
        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" 
                   name="nama" 
                   value="{{ $product->name }}" 
                   class="form-control" 
                   placeholder="Contoh: Daster Rempel">
        </div>

        <!-- DESKRIPSI -->
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" 
                      class="form-control" 
                      placeholder="Masukkan deskripsi produk...">{{ $product->description }}</textarea>
        </div>

        <!-- GRID -->
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Stok</label>
                <input type="number" 
                       name="stok" 
                       value="{{ $product->stock }}" 
                       class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Harga</label>
                <input type="number" 
                       name="harga" 
                       value="{{ $product->price }}" 
                       class="form-control">
            </div>
        </div>

        <!-- KATEGORI -->
        <div class="mb-3 mt-3">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-control">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" 
                        {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- GAMBAR LAMA -->
        <div class="mb-3">
            <label class="form-label">Gambar Utama</label><br>
            <img src="{{ asset('images/' . $product->image) }}" 
                 width="120" 
                 class="rounded shadow-sm">
        </div>

        <!-- MULTI IMAGE -->
        <div class="mb-3">
            <label class="form-label">Tambah Gambar Baru</label>
            <input type="file" name="gambar[]" multiple class="form-control">
            <small class="text-muted">Bisa upload lebih dari 1 gambar</small>
        </div>

        <!-- LIST GAMBAR -->
        <div class="mb-3">
            <label class="form-label">Galeri Produk</label>

            <div class="d-flex flex-wrap gap-2">

                @foreach($product->images as $img)
                    <div class="position-relative">

                        <img src="{{ asset('images/' . $img->image) }}" 
                             width="80" 
                             class="rounded border">

                        <!-- tombol delete -->
                        <button type="button"
                                class="btn btn-danger btn-sm p-1 btn-delete-img"
                                data-id="{{ $img->id }}">
                            ×
                        </button>

                    </div>
                @endforeach

            </div>
        </div>

        <!-- BUTTON -->
        <button type="submit" class="btn btn-dark px-4">
            Update Produk
        </button>

    </form>

</div>

@endsection

<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.btn-delete-img').forEach(btn => {
        btn.addEventListener('click', function() {

            if (!confirm('Hapus gambar?')) return;

            let id = this.dataset.id;

            fetch(`/product-image/${id}`, {
                method: 'POST', // 🔥 PAKAI POST + METHOD SPOOFING
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    _method: 'DELETE'
                })
            })
            .then(res => {
                if (!res.ok) throw new Error('Gagal hapus');
                return res.text();
            })
            .then(() => {
                location.reload();
            })
            .catch(err => {
                console.error(err);
                alert('Gagal hapus gambar');
            });

        });
    });

});
</script>