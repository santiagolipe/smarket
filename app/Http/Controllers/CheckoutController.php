<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Lojista;
use App\DeliveryFee;
use App\Order;
use App\OrderItem;
use App\Product;

use App\Utils;

class CheckoutController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        if (session()->has('cart')) {
            $cart = session()->get('cart');
            $market = User::where('type', Lojista::type)->findOrFail($cart['market']);
            $deliveryfee = DeliveryFee::where('user', $market->id)->where('localization', 'LIKE', Utils::normalize($cart['delivery']['district']))->get()->first();
            $cart['delivery']['fee'] = !empty($deliveryfee) ? $deliveryfee->fee : $market->extra->default_delivery_fee;
            $cart['delivery']['time'] = !empty($deliveryfee) ? $deliveryfee->time : 0;
            $cart['total'] = $cart['subtotal'] + $cart['delivery']['fee'];
            session(['cart' => $cart]);

            return view('checkout')->with('market', $market)->with('cart', $cart);
        }

        return view('checkout');
    }

    protected function checkout(Request $request) {
        if (!session()->has('cart')) {
            return back();
        }

        $request->validate([
            'subtotal' => 'required|numeric',
            'deliveryfee' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $cart = session()->get('cart');
        $market = User::where('type', Lojista::type)->findOrFail($cart['market']);

        // Start Database Transaction
        DB::beginTransaction();

        $order = Order::create([
            'user' => Auth::id(),
            'market' => $cart['market'],
            'delivery' => $request->delivery,
            'address' => $cart['delivery']['address'],
            'number' => $cart['delivery']['number'],
            'district' => $cart['delivery']['district'],
            'payment' => $request->payment,
            'subtotal' => $cart['subtotal'],
            'delivery_fee' => 'pickup' == $request->delivery ? 0.0 : $cart['delivery']['fee'],
            'total' => $cart['total']
        ]);

        $itemsSuccess = true;
        foreach ($cart['items'] as $id => $data) {
            $product = Product::where('user', $cart['market'])->findOrFail($id);

            if ( $product->qty < $data['qty'] ) {
                $itemsSuccess = false;

                break;
            }

            $orderItem = OrderItem::create([
                'order' => $order->id,
                'product' => $id,
                'qty' => $data['qty'],
                'price' => $data['price'],
            ]);
            $product->qty -= $data['qty'];

            $itemsSuccess = $itemsSuccess && $orderItem && $product && $product->save();
        }

        $market->extra->sales += 1;

        if ($order && $itemsSuccess && $market->extra->save()) {
            DB::commit();
            session()->forget('cart');
        } else {
            DB::rollback();

            return back()->with('fail', 'Não foi possível finalizar a compra. Tente novamente mais tarde.');
        }

        return back()->with('success', 'Compra finalizada com sucesso!');
    }
}
