<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Lojista;
use App\Product;

class LojistaController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function list() {
        $order = request()->has('order') ? explode('+', request('order')) : ['id', 'asc'];
        $markets = User::where('type', Lojista::type)->where('name', 'LIKE', '%'.request('search').'%');
        if (strpos($order[0], 'sales') !== false) {
            $markets->join('lojistas', 'lojistas.user', '=', 'users.id')->select('users.*'); // Avoid selecting everything from the stocks table
        }

        return view('markets.list')->with('markets', $markets->orderBy($order[0], $order[1])->get()->all());
    }

    public function items($id) {
        $order = request()->has('order') ? explode('+', request('order')) : ['id', 'asc'];
        $market = User::where('type', Lojista::type)->find($id);

        if (empty($market)) {
            return redirect()->route('users.lojista.list');
        }

        $products = Product::where('user', $id)->where('name', 'LIKE', '%'.request('search').'%');
        if (!empty(request('dept'))) {
            $products = $products->where('dept', request('dept'));
        }

        $depts = Product::where('user', $market->id)->select('dept')->distinct()->get()->all();

        return view('markets.items')->with('products', $products->orderBy($order[0], $order[1])->get()->all())->with('market', $market)->with('dept', request('dept'))->with('depts', $depts);
    }

    public function item($id, $product) {
        $market = User::where('type', Lojista::type)->find($id);

        if (empty($market)) {
            return redirect()->route('users.lojista.list');
        }

        $product = Product::where('user', $id)->find($product);

        if (empty($product)) {
            return redirect()->route('users.lojista.items', $id);
        }

        $depts = Product::select('dept')->distinct()->get()->all();

        return view('markets.item')->with('product', $product)->with('market', $market)->with('dept', $product->dept)->with('depts', $depts);
    }
}
