<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request){
        //

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('username','password');

        if(auth()->attempt($credentials)){
            return redirect()->route('user.index')->with('success', 'Anda berhasil login');
        }else{
            return redirect()->route('login.index')->withErrors(['username' => 'Username atau Password Salah']);
        }
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('login.index');
    }
}
