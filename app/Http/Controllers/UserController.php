<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Lojista;

class UserController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $user = Auth::user();
        return view('my-account', compact('user') );
    }

    public function update($id) {
        $user = User::find($id);

        $userValidator = [
            'name' => 'required|string|max:255',
            'reg' => 'required|string|max:18|unique:users,'.request()->segment(2),
            'email' => 'required|string|email|max:255|unique:users,email,'.request()->segment(2),
            'password' => 'present'.(!empty(request('password')) ? '|confirmed' : '').
                (!empty(request('password_confirmation')) ? '|min:6' : ''),
            'terms' => 'accepted',
        ];

        if ($user->type === Lojista::type)
            $this->validate(request(), array_merge($userValidator, [
                'companyname' => 'required|string|max:255',
                'owner' => 'required|string|max:255',
                'desc' => 'required|string|max:255',
                'logo' => 'image|mimes:jpeg,jpg,png',
                'phone' => 'required|string|max:15',
                'address' => 'required|string|max:255',
                'number' => 'required|string|max:11',
                'district' => 'required|string|max:255',
                'complement' => 'max:255',
                'defaultdeliveryfee' => 'required|numeric|min:0',
            ]));
        else
            $this->validate(request(), array_merge($userValidator, [
                'surname' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'address' => 'required|string|max:255',
                'number' => 'required|string|max:11',
                'district' => 'required|string|max:255',
                'complement' => 'max:255',
            ]));

        $user->name = request('name');
        $user->reg = request('reg');
        $user->email = request('email');

        if ( request('password') !== null ) {
            $user->password = bcrypt(request('password'));
        }

        $extra = $user->extra;

        if ($user->type === Lojista::type) {
            $extra->companyname = request('companyname');
            $extra->owner = request('owner');
            $extra->desc = request('desc');
            $extra->phone = request('phone');
            $extra->address = request('address');
            $extra->number = request('number');
            $extra->district = request('district');
            $extra->complement = request('complement');
            $extra->default_delivery_fee = request('defaultdeliveryfee');

            if (request()->hasFile('logo') && $extra->logo !== 'uploads/images/' . $user->id . request('logo')->getClientOriginalName()) {
                $extra->logo = $this->uploadImage(request('logo'), $user->id);
            }
        } else {
            $extra->surname = request('surname');
            $extra->phone = request('phone');
            $extra->address = request('address');
            $extra->number = request('number');
            $extra->district = request('district');
            $extra->complement = request('complement');
        }


        if ($extra->save() && $user->save()) {
            return back()->with('success', 'Dados alterados com sucesso!');
        } else {
            return back()->with('fail', 'Não foi possível alterar o usuário. Tente novamente mais tarde.');
        }
    }

    public function delete($id) {
        if (Auth::id() != $id) {
            return back();
        }

        if (Auth::user()->type == Lojista::type) {
            $user = User::whereDoesntHave('marketOrders')->whereDoesntHave('marketProducts')->find($id);

            if (!$user) {
                return back()->with('fail', 'Não é possível excluir esse usuário, pois existe um ou mais produto cadastrado e/ou compra realizada nesse supermercado.
                Contate o desenvolvedor do sistema caso queira excluir permanentemente essa conta.');
            }
        } else {
            $user = User::whereDoesntHave('orders')->find($id);

            if (!$user) {
                return back()->with('fail', 'Não é possível excluir esse usuário, pois pois você realizou uma ou mais compras.
                Contate o desenvolvedor do sistema caso queira excluir permanentemente essa conta.');
            }
        }


        Auth::logout();
        $user = User::find($id);
        $extra = $user->extra;

        if ($extra->delete() && $user->delete()) {
            return redirect()->route('index');
        } else {
            return back()->with('fail', 'Não foi possível excluir o usuário. Tente novamente mais tarde.');
        }
    }

    private function uploadImage($image, $userId) {
        if (!$image) {
            return null;
        }

        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('uploads/images/' . $userId), $imageName);

        return 'uploads/images/' . $userId . '/' . $imageName;
    }
}
