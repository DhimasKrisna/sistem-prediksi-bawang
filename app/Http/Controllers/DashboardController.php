<?php

namespace App\Http\Controllers;

use App\Models\Harga;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        
        $harga = Harga::orderBy('tanggal', 'desc')->get();
        $users = User::get();

        $data = [
            'hargas' => $harga,
            'users' => $users
        ];


        return view('dashboard.index', $data);
    }
}
