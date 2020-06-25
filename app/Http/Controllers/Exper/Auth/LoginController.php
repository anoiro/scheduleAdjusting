<?php

namespace App\Http\Controllers\Exper\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::EXPER_HOME;
    
    public function __construct()
    {
        $this->middleware('guest:exper')->except('logout');
        //print('logincontroller');
    }

    protected function guard()
    {
        return Auth::guard('exper');
    }

    public function showLoginForm()
    {
        return view('exper.auth.login');
    }

    public function logout(Request $request)
    {
        Auth::guard('exper')->logout();
        return $this->loggedOut($request);
    }

    public function loggedOut(Request $request)
    {
        return redirect(route('exper.login'));
    }
}