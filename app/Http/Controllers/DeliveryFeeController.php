<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DeliveryFee;
use App\User;
use App\Lojista;

use App\Utils;

class DeliveryFeeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function create(Request $request) {
        $request->merge([
            'localizationraw' => $request->localization,
            'localization' => Utils::normalize($request->localization)
        ]);
        request()->validate([
            'localization' => 'required|string|unique:deliveryfees',
            'localizationraw' => 'required|string',
            'time' => 'required|integer',
            'fee' => 'required|numeric',
        ]);

        $deliveryfee = DeliveryFee::create([
            'user' => Auth::id(),
            'localization' => $request->localization,
            'localizationraw' => $request->localizationraw,
            'time' => $request->time,
            'fee' => $request->fee,
        ]);

        if (!$deliveryfee) {
            return back()->with('fail', 'Não foi possível adicionar a entrega. Tente novamente mais tarde.')->with('open-add', true);
        }

        return back()->with('success', 'Dados de entrega adicionado com sucesso!')->with('open-add', true);
    }

    public function update(Request $request, $id) {
        $request->merge([
            'localizationraw' => $request->localization,
            'localization' => Utils::normalize($request->localization)
        ]);
        $request->validate([
            'localization' => 'required|string|unique:deliveryfees,localization,'.$id,
            'localizationraw' => 'required|string',
            'time' => 'required|integer',
            'fee' => 'required|numeric',
        ]);

        $deliveryfee = DeliveryFee::where('user', Auth::user()->id)->where('id', $id)->first();

        $deliveryfee->localization = $request->localization;
        $deliveryfee->localizationraw = $request->localizationraw;
        $deliveryfee->time = $request->time;
        $deliveryfee->fee = $request->fee;

        if ($deliveryfee->save()) {
            return back()->with('success', 'Dados de entrega atualizado com sucesso!')->with('open-add', true);
        }

        return back()->with('fail', 'Não foi possível atualizar a entrega. Tente novamente mais tarde.')->with('open-add', true);
    }

    public function delete($id) {
        $deliveryfee = DeliveryFee::where('user', Auth::user()->id)->find($id);

        if ($deliveryfee->delete()) {
            return back()->with('success', 'Entrega excluída com sucesso!');
        } else {
            return back()->with('fail', 'Não foi possível excluir a entrega. Tente novamente mais tarde.');
        }
    }

    public function clearFee() {
        if (!session()->has('cart')) {
            return response()->json(['result' => 'fail', 'msg' => 'O carrinho está vazio.']);
        }

        $cart = session()->get('cart');
        $cart['delivery']['fee'] = 0.0;
        $cart['total'] = $cart['subtotal'] + $cart['delivery']['fee'];

        session(['cart' => $cart]);

        return response()->json(['result' => 'success']);
    }

    public function findAndUpdateCart(Request $request) {
        if (!session()->has('cart')) {
            return response()->json(['fail' => 'O carrinho está vazio.']);
        }

        $cart = session()->get('cart');
        $cart['delivery']['address'] = $request->delivery['address'];
        $cart['delivery']['number'] = $request->delivery['number'];
        $cart['delivery']['district'] = $request->delivery['district'];
        $market = User::where('type', Lojista::type)->findOrFail($cart['market']);
        $deliveryfee = DeliveryFee::where('user', $market->id)->where('localization', 'LIKE', Utils::normalize($request->delivery['district']))->get()->first();
        $cart['delivery']['fee'] = !empty($deliveryfee) ? $deliveryfee->fee : $market->extra->default_delivery_fee;
        $cart['delivery']['time'] = !empty($deliveryfee) ? $deliveryfee->time : 0;
        $cart['total'] = $cart['subtotal'] + $cart['delivery']['fee'];

        session(['cart' => $cart]);

        $result = [
            'deliveryfee' => $cart['delivery']['fee'],
            'deliveryfee_formatted' => 'R$ ' . number_format($cart['delivery']['fee'], 2, ',', '.'),
            'total' => $cart['total'],
            'total_formatted' => 'R$ ' . number_format($cart['total'], 2, ',', '.'),
        ];

        return response()->json($result);
    }

    public function list() {
        $search = request('search');
        return DeliveryFee::where('user', Auth::id())->where('localization', 'like', '%' . Utils::normalize($search) . '%')->orWhere('id', $search)->paginate(9)->links('delivery');
    }
}
