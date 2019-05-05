<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\OrderItem;

class OrderController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function list() {
        return Order::where('user', Auth::user()->id)->paginate(9)->links('my-orders');
    }

    public function listMarket() {
        return Order::where('market', Auth::user()->id)->paginate(9)->links('sales');
    }

    public function report() {
        return Order::where('market', Auth::user()->id)->join('orderitems', 'orderitems.order', '=', 'orders.id')
        ->join('products', 'orderitems.product', '=', 'products.id')->orderBy('orderitems.product')->groupBy('orderitems.product')
        ->select(['products.id', 'products.name', 'products.brand', DB::raw('sum(orderitems.qty) as totalqty'), DB::raw('(sum(orderitems.qty) * orderitems.price) as total')])
        ->paginate(9)->links('sales-report');
    }

    public function printReport() {
        return view('print.sales-report')->with('orders', Order::where('market', Auth::user()->id)->join('orderitems', 'orderitems.order', '=', 'orders.id')
        ->join('products', 'orderitems.product', '=', 'products.id')->orderBy('orderitems.product')->groupBy('orderitems.product')
        ->select(['products.id', 'products.name', 'products.brand', DB::raw('sum(orderitems.qty) as totalqty'), DB::raw('(sum(orderitems.qty) * orderitems.price) as total')])->get());
    }

    public function print($id) {
        return view('print.order')->with('order', Order::where('market', Auth::user()->id)->find($id));
    }
}
