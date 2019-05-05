<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Cliente;
use App\Lojista;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $userValidator = [
            'name' => 'required|string|max:255',
            'reg' => 'required|string|max:18|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'type' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'accepted',
        ];

        if (isset($data['type']) and $data['type'] === Lojista::type)
            return Validator::make($data, array_merge($userValidator, [
                'companyname' => 'required|string|max:255',
                'owner' => 'required|string|max:255',
                'logo' => 'image|mimes:jpeg,jpg,png',
                'desc' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'address' => 'required|string|max:255',
                'number' => 'required|string|max:11',
                'district' => 'required|string|max:255',
                'complement' => 'max:255',
            ]));
        else
            return Validator::make($data, array_merge($userValidator, [
                'surname' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'address' => 'required|string|max:255',
                'number' => 'required|string|max:11',
                'district' => 'required|string|max:255',
                'complement' => 'max:255',
            ]));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return (\App\Lojista || \App\Cliente)
     */
    protected function create(array $data) {
        // Start Database Transaction
        DB::beginTransaction();

        $user = User::create([
            'name' => $data['name'],
            'reg' => $data['reg'],
            'email' => $data['email'],
            'type' => $data['type'],
            'password' => bcrypt($data['password']),
        ]);

        if ($user) {
            if (isset($user['type']) and $user['type'] === Lojista::type)
                $extra = Lojista::create([
                    'user' => $user['id'],
                    'companyname' => $data['companyname'],
                    'desc' => $data['desc'],
                    'owner' => $data['owner'],
                    // 'image' => $this->uploadImage($data['image'], $user['id']),
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'number' => $data['number'],
                    'district' => $data['district'],
                    'complement' => $data['complement'],
                ]);
            else
                $extra = Cliente::create([
                    'user' => $user['id'],
                    'surname' => $data['surname'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'number' => $data['number'],
                    'district' => $data['district'],
                    'complement' => $data['complement'],
                ]);
        }

        if ($user && $extra) {
            DB::commit();
        } else {
            DB::rollback();

            return NULL;
        }

        return $user;
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
