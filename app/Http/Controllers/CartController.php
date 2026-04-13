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
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'qty' => 1
            ];
        }

        session()->put('cart', $cart);

        // 🔥 CEK: kalau dari AJAX
        if ($request->ajax()) {
            return response()->json([
                'cartCount' => count($cart)
            ]);
        }

        // 🔥 kalau dari tombol checkout (form)
        return redirect('/cart');
    }

    // update qty manual (optional)
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['qty'] = max(1, (int)$request->qty);
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // tambah qty
    public function increase($id)
    {
        $cart = session()->get('cart');

        $cart[$id]['qty']++;

        session()->put('cart', $cart);

        return response()->json([
            'qty' => $cart[$id]['qty'],
            'total' => $this->getTotal($cart),
            'cartCount' => count($cart)
        ]);
    }

    // kurang qty
    public function decrease($id)
    {
            $cart = session()->get('cart');

            if ($cart[$id]['qty'] > 1) {
                $cart[$id]['qty']--;
            }

            session()->put('cart', $cart);

            return response()->json([
                'qty' => $cart[$id]['qty'],
                'total' => $this->getTotal($cart),
                'cartCount' => count($cart)
            ]);
    }
    private function getTotal($cart)
    {
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return number_format($total);
    }

    // hapus item
    public function remove($id)
    {
        $cart = session()->get('cart');

        unset($cart[$id]);

        session()->put('cart', $cart);

        return response()->json([
            'total' => $this->getTotal($cart),
            'cartCount' => count($cart)
        ]);
    }
}