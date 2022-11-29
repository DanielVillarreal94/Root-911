<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginForm()
    {
        $action['action'] = 'login';
        return view('access.form', $action);
    }

    public function login(Request $request){
        $credentials = request()->validate([
            'username' => ['required', 'string'], 
            'password' => ['required', 'string']
        ]);
        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
            return redirect('user')->with('message', Auth::user());
        } 
       return redirect('login_form')->with('error', 'Authentication error');

    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        //se invalida la sesion anterior
        $request->session()->invalidate();
        //Se crea nuevo token para @csrf
        $request->session()->regenerateToken();
        return redirect('login_form');
    }
}
