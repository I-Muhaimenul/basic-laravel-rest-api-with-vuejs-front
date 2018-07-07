<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;

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
    protected function credentials(Request $request)
    {
        //return $request->only($this->username(), 'password');
        $credentials = $request->only('email', 'password');
        $credentials = array_add($credentials, 'status', 1);
        return $credentials;
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if($user->role === 1) {
            return redirect()->intended('/adminDash')->with('status',('Welcome back, '. $user->name));
        }else if($user->role === 2){
            return redirect()->intended('/userDash')->with('status',('Welcome back, '. $user->name));
        }

        Auth::logout();
        return redirect()->intended('/login');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        Session::flash('success', 'Your Email is Sent!');
        return redirect('login')->with('status','You are logged out.');

    }



    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


}
