<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TmpHarga;

class TmpHargaController extends Controller
{
    //
    public function index()
    {
        $tmpharga = Tmpharga::get();

        $data = [
            'tmphargas' => $tmpharga
        ];
        
        return view('tmpharga.index', $data);
    }
}
