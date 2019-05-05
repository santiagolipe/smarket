<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Lojista;
use App\Product;
use App\DeliveryFee;

use App\Utils;

class CartController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function addToCart(Request $request) {
        $request->validate([
            'productId' => 'required',
        ]);

        $product = Product::findOrFail($request->productId);

        $request->validate([
            'qty' => 'required|integer|min:1|max:' . $product->qty,
        ]);

        $market = User::where('type', Lojista::type)->findOrFail($product->user);
        $time = 0;
        if (session()->has('cart')) {
            $time = session()->get('cart')['delivery']['time'];
        } else {
            $deliveryfee = DeliveryFee::where('user', $market->id)->where('localization', Utils::normalize(Auth::user()->extra->district))->get()->first();
            if ($deliveryfee) {
                $time = $deliveryfee->time;
            }
        }

        $depts = Product::select('dept')->distinct()->get()->all();
        $cart = session()->has('cart') ? session()->get('cart') : [
            'market' => $market->id,
            'items' => [],
            'subtotal' => 0.0,
            'total' => 0.0,
            'delivery' => [
                'fee' => 0.0,
                'time' => $time,
                'address' => Auth::user()->extra->address,
                'number' => Auth::user()->extra->number,
                'district' => Auth::user()->extra->district,
            ]
        ];

        if ( $product->user != $cart['market'] ) {return redirect()->route('users.lojista.item', ['id' => $market, 'product' => $product])->with('fail', 'Não é possível comprar itens de supermercados diferentes.');
        }

        if ( $product->qty < ($request->qty + (isset($cart['items'][$product->id]) ? $cart['items'][$product->id]['qty'] : 0)) ) {
            return redirect()->route('users.lojista.item', ['id' => $market, 'product' => $product])->with('fail', 'Não foi possível adicionar o item no carrinho, pois a quantidade informada excede o total disponível no estoque.');
        }

        if (array_key_exists($product->id, $cart['items'])) {
            $cart['items'][$product->id]['qty'] += $request->qty;
            // $cart['total'] += ($request->qty * $product->price);
        } else {
            $cart['items'][$product->id] = [
                'name' => $product->name,
                'qty' => $request->qty,
                'price' => $product->price,
            ];
        }

        $cart['subtotal'] += ($request->qty * $product->price);
        $cart['total'] = $cart['subtotal'] + $cart['delivery']['fee'];

        session(['cart' => $cart]);

        return true;
    }

    public function addItem(Request $request) {
        $result = $this->addToCart($request);

        if ($result === true) {
            $product = Product::findOrFail($request->productId);

            return redirect()->route('users.lojista.item', ['id' => $product->user, 'product' => $product->id])->with('success', 'Produto adicionado ao carrinho.');
        }

        return $result;
    }

    public function buyNow(Request $request) {
        $result = $this->addToCart($request);

        if ($result === true) {
            return redirect()->route('checkout')->with('success', 'Produto adicionado ao carrinho.')->with('back', url()->previous());
        }

        return $result;
    }

    public function clear() {
        session()->forget('cart');

        return redirect()->route('home');
    }

    public function removeItem($itemId) {
        $cart = session()->get('cart');
        $item = $cart['items'][$itemId];
        $cart['subtotal'] -= ($item['qty'] * $item['price']);
        $cart['total'] = $cart['subtotal'] + $cart['delivery']['fee'];
        unset($cart['items'][$itemId]);

        if (empty($cart['items'])) {
            return $this->clear();
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Item removido do carrinho.');
    }
}
