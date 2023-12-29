<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (auth()->user()->role == 'mega' || auth()->user()->role == 'superadmin') {
                return redirect()->route('mega.agent.dashboard');
            } 
            
            elseif (auth()->user()->role == 'super') {
                return redirect()->route('super.agent.dashboard');
            } 
            
            elseif (auth()->user()->role == 'sub') {
                return redirect()->route('sub.agent.dashboard');
            } 
            
            elseif (auth()->user()->role == 'agent') {
                return redirect()->route('agent.dashboard');
            }

            else{
                return redirect()->route('web.auth.login')->withError("You don't have an access to this priviledge");
            }
        }

        return redirect()->route("web.auth.login")->withError("Oppes! You have entered invalid credentials");
    }

    public function logout()
    {
        Session::flush();

        Auth::logout();
  
        return redirect()->route('web.auth.login')->withSuccess("You have sucessfully logged out!");
    }

}
