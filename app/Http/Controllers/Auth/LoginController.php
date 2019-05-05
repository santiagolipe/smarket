<?php

namespace App\Http\Controllers\Auth;

use App\Lojista;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     * It overrides the function showLoginForm defined in the trait
     * Illuminate\Foundation\Auth\AuthenticatesUsers
     * https://stackoverflow.com/a/40818942
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Validate the user login request.
     * It overrides the function validateLogin defined in the trait
     * Illuminate\Foundation\Auth\AuthenticatesUsers
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * The user has been authenticated.
     * It overrides the function authenticated defined in the trait
     * Illuminate\Foundation\Auth\AuthenticatesUsers
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    // protected function authenticated(Request $request, $user)
    // {
    //     if ( Lojista::type == $user->type ) {
    //         return redirect()->route('/filco/home');
    //     }
    //
    //      return redirect('/home');
    // }

    /**
     * Get the failed login response instance.
     * It overrides the function sendFailedLoginResponse defined in the trait
     * Illuminate\Foundation\Auth\AuthenticatesUsers
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     * It overrides the function username defined in the trait
     * Illuminate\Foundation\Auth\AuthenticatesUsers
     *
     * @return string
     */
    public function username()
    {
        $login = request()->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'reg';
        request()->merge([$field => $login]);

        return $field;
    }
}
