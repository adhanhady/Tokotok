<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
{
    // 🔥 LIST DATA
    public function index()
    {
        $categories = ProductCategory::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    // 🔥 FORM TAMBAH
    public function create()
    {
        return view('categories.create');
    }

    // 🔥 SIMPAN
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255|unique:categories,nama'
        ], [
            'nama.required' => 'Nama kategori wajib diisi!',
            'nama.unique' => 'Kategori sudah ada!'
        ]);

        ProductCategory::create([
            'nama' => $request->nama
        ]);

        return redirect('/categories')->with('success', 'Kategori berhasil ditambahkan');
    }

    // 🔥 FORM EDIT
    public function edit($id)
    {
        $cat = ProductCategory::findOrFail($id);
        return view('categories.edit', compact('cat'));
    }

    // 🔥 UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:255'
        ]);

        $cat = ProductCategory::findOrFail($id);

        $cat->update([
            'nama' => $request->nama
        ]);

        return redirect('/categories')->with('success', 'Kategori berhasil diupdate');
    }

    // 🔥 DELETE
    public function destroy($id)
    {
        ProductCategory::destroy($id);
        return redirect('/categories')->with('success', 'Kategori berhasil dihapus');
    }
}