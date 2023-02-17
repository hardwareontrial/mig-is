<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('email'))){
            return ['nik'=>$request->get('email'),'password'=>$request->get('password')];
        }
        elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password'=>$request->get('password')];
        }
    }

    protected function login(Request $request)
    {
        if (auth()->attempt(array('email' => $request->input('email'), 'password' => $request->input('password')),true) || 
        auth()->attempt(array('nik' => $request->input('email'), 'password' => $request->input('password')),true))
        {
            $user = User::where('email','=',$request->input('email'))
                        ->orWhere('nik','=',$request->input('email'))
                        ->first();
            if ($user['is_active'] == 1) {
                return redirect()->route('home');
            } else {
                Auth::logout();
                return redirect()->route('login')
                ->with('danger', 'Akun anda telah di non-akitfkan');
            }
        } else {
            return redirect()->route('login')
                ->with('danger', 'Email/NIK atau Password salah');
        }
    }
}
