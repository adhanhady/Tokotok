<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
class ProductController extends Controller
{
    // Tampilkan semua produk
    public function index(Request $request)
    {
        $query = Product::with('category');

    // 🔍 SEARCH
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    // 🧩 FILTER KATEGORI
    if ($request->category) {
        $query->where('category_id', $request->category);
    }

    // 📄 PAGINATION
    $products = $query->latest()->paginate(8)->withQueryString();

    // ambil kategori
    $categories = ProductCategory::all();

    // ADMIN
    if (auth()->check() && auth()->user()->role == 'admin') {
        return view('admin.products.index', compact('products', 'categories'));
    }

    // USER
    return view('user.products.index', compact('products'));
    }
    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%' . $request->search . '%')
            ->limit(5)
            ->get();

        return response()->json($products);
    }

    // Form tambah produk
    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.products.create', compact('categories'));
    }

    // Simpan produk
    public function store(Request $request)
    {
        $request->validate([
        'nama' => 'required|max:255',
        'deskripsi' => 'required',
        'stok' => 'required|integer',
        'harga' => 'required|numeric',
        'category_id' => 'required',
        'gambar' => 'required',
        'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048'
    ]);

        // 🔥 BUAT PRODUK DULU
        $product = Product::create([
            'name' => $request->nama,
            'description' => $request->deskripsi,
            'stock' => $request->stok,
            'price' => $request->harga,
            'category_id' => $request->category_id,
            'image' => '' // sementara
        ]);

        // 🔥 SIMPAN MULTI IMAGE
        if ($request->hasFile('gambar')) {

            $firstImage = null;

            foreach ($request->file('gambar') as $index => $file) {

                $fileName = time() . '_' . uniqid() . '.' . $file->extension();
                $file->move(public_path('images'), $fileName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileName
                ]);

                if ($index === 0) {
                    $firstImage = $fileName;
                }
            }

            // 🔥 SET GAMBAR UTAMA
            $product->update([
                'image' => $firstImage
            ]);
        }

        return redirect('/products')->with('success', 'Produk berhasil ditambahkan');
    }

    // Detail produk
    public function show($id)
    {
        $product = Product::findOrFail($id);

        $product->increment('views');   
        $product = Product::with('images')->findOrFail($id);

        return view('user.products.show', compact('product'));
    }

    // Form edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();

       return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
          $request->validate([
        'nama' => 'required|max:255',
        'deskripsi' => 'required',
        'stok' => 'required|integer',
        'harga' => 'required|numeric',
        'category_id' => 'required',
        'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $product = Product::findOrFail($id);

    // 🥇 UPDATE DATA UTAMA
    $product->update([
        'name' => $request->nama,
        'description' => $request->deskripsi,
        'stock' => $request->stok,
        'price' => $request->harga,
        'category_id' => $request->category_id,
    ]);

    // 🥇 HANDLE MULTI IMAGE BARU
    if ($request->hasFile('gambar')) {

        $firstImage = null;

        foreach ($request->file('gambar') as $index => $file) {

            $fileName = time() . '_' . uniqid() . '.' . $file->extension();
            $file->move(public_path('images'), $fileName);

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $fileName
            ]);

            // set gambar pertama jadi thumbnail
            if ($index === 0) {
                $firstImage = $fileName;
            }
        }

        // 🥇 UPDATE GAMBAR UTAMA
        if ($firstImage) {
            $product->update([
                'image' => $firstImage
            ]);
        }
    }

    return redirect('/products')->with('success', 'Produk berhasil diupdate');
    }

    // Hapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // hapus gambar
        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete();

        return redirect('/products')->with('success', 'Produk berhasil dihapus');
    }
}