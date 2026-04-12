<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    // Tampilkan semua produk
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    // Form tambah produk
    public function create()
    {
        $categories = ProductCategory::all();
        return view('products.create', compact('categories'));
    }

    // Simpan produk
    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'category_id' => 'required'
        ]);

        // SIMPAN (mapping)
        Product::create([
            'name' => $request->nama,
            'description' => $request->deskripsi,
            'stock' => $request->stok,
            'price' => $request->harga,
            'category_id' => $request->category_id,
            'image' => $request->gambar ?? 'default.jpg'
        ]);

        return redirect('/products')->with('success', 'Produk berhasil ditambahkan');
    }

    // Detail produk
    public function show($id)
    {
          $product = Product::findOrFail($id);

            // tambah klik
            $product->increment('views');

            return view('products.show', compact('product'));
    }

    // Form edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect('/products')->with('success', 'Produk diupdate');
    }

    // Hapus produk
    public function destroy($id)
    {
        Product::destroy($id);
        return redirect('/products')->with('success', 'Produk dihapus');
    }
}