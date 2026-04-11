<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // tampilkan cart
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('pages.cart', compact('cart'));
    }

    // tambah ke cart
    public function add($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                "nama" => $product->nama,
                "harga" => $product->harga,
                "gambar" => $product->gambar,
                "qty" => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }
    // update qty
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            $cart[$id]['qty'] = $request->qty;
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // tambah qty
    public function increase($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            $cart[$id]['qty']++;
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // kurang qty
    public function decrease($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            if($cart[$id]['qty'] > 1) {
                $cart[$id]['qty']--;
            } else {
                unset($cart[$id]); // kalau 1 jadi hapus
            }

            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // hapus
    public function remove($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }
}