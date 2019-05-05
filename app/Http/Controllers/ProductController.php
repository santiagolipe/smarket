<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;

class ProductController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('product.new')->with('newCod', $this->newCod());
    }

    private function newCod() {
        return Product::withTrashed()->max('id')+1;
    }

    public function create(Request $request) {
        request()->validate([
            'name' => 'required|string',
            'qty' => 'required|integer',
            'brand' => 'required|string',
            'dept' => 'required|string',
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
            'desc' => 'required|string',
            'image' => 'image|mimes:jpeg,jpg,png',
            'terms' => 'accepted'
        ]);

        Product::create([
            'user' => Auth::id(),
            'name' => $request->name,
            'qty' => $request->qty,
            'brand' => $request->brand,
            'dept' => $request->dept,
            'weight' => $request->weight,
            'price' => $request->price,
            'desc' => $request->desc,
            'image' => $this->uploadImage($request->image)
        ]);

        return back()->with('success', 'Produto cadastrado com sucesso!');
    }

    private function uploadImage($image) {
        if (!$image) {
            return null;
        }

        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('uploads/images/' . Auth::id() . '/product'), $imageName);

        return 'uploads/images/' . Auth::id() . '/product/' . $imageName;
    }

    public function list() {
        $search = request('search');
        return Product::withTrashed()->where('user', Auth::id())->where('name', 'like', '%' . $search . '%')->orWhere('id', $search)->paginate(9)->links('product.list');
    }

    public function edit($id) {
        return view('product.edit')->with('product', Product::find($id));
    }

    public function update($id) {
        $product = Product::find($id);

        request()->validate([
            'name' => 'required|string',
            'qty' => 'required|integer',
            'brand' => 'required|string',
            'dept' => 'required|string',
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
            'desc' => 'required|string',
            'image' => 'image|mimes:jpeg,jpg,png',
            'terms' => 'accepted'
        ]);

        $product->name = request('name');
        $product->qty = request('qty');
        $product->brand = request('brand');
        $product->dept = request('dept');
        $product->weight = request('weight');
        $product->price = request('price');
        $product->desc = request('desc');

        if (request()->hasFile('image') && $product->image !== 'uploads/images/' . Auth::id() . '/product/' . request('image')->getClientOriginalName()) {
            $product->image = $this->uploadImage(request('image'));
        }

        if ($product->save()) {
            return back()->with('success', 'Produto alterado com sucesso!');
        } else {
            return back()->with('fail', 'Não foi possível alterar o produto. Tente novamente mais tarde.');
        }
    }

    public function delete($id) {
        $product = Product::withTrashed()->where('id', $id)->first();

        if ($product->delete()) {
            return back()->with('success', 'Produto excluído com sucesso!');
        } else {
            return back()->with('fail', 'Não foi possível excluir o produto. Tente novamente mais tarde.');
        }
    }

    public function restore($id) {
        $product = Product::withTrashed()->where('id', $id)->first();

        if ($product->restore()) {
            return back()->with('success', 'Produto restaurado com sucesso!');
        } else {
            return back()->with('fail', 'Não foi possível restaurar o produto. Tente novamente mais tarde.');
        }
    }
}
