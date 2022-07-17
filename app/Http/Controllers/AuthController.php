<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        // return view('auth.login');
        return view('login.index');
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

    public function gantiPassword(){
        return view('auth.gantiPass');
    }

    public function gantiPasswordAct(Request $request){
        $request->validate([
            'password' => 'required|confirmed',
            'password_lama' => 'current_password:web'
        ]);

        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login.gantiPass')->with('success','password berhasil diganti');
    }
}
