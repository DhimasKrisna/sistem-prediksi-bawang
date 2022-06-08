<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();

        $data = [
            'users' => $users
        ];
        
        return view('user.index', $data);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'role' => 'required',
            'password' => 'required|confirmed'
        ]);

        // dd($request->all());

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.index')->with('success', 'User Berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        // dd($user);

        $data = [
            'user' => $user
        ];
        return view('user.edit', $data);
    }

    public function update(Request $request, User $user)
    {
        //
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users'.$user->id,
            'role' => 'required',
            'password' => 'nullable|confirmed'
        ]);

        // dd($request->all());

        if($request->password){
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User Berhasil diubah');
    }

}
