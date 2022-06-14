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

    public function create()
    {
        return view('tmpharga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'harga' => 'required'
        ]);

        // dd($request->all());

        $harga = new Tmpharga;
        $harga->tanggal = $request->tanggal;
        $harga->harga = $request->harga;
        // dd($harga);
        $harga->save();

        return redirect()->route('tmpharga.index')->with('success', 'Data Berhasil ditambahkan');
    }

    public function edit(Tmpharga $tmpharga)
    {
        // dd($tmpharga);

        $data = [
            'harga' => $tmpharga
        ];

        return view('tmpharga.edit', $data);
    }

    public function update(Request $request, Tmpharga $tmpharga)
    {
        //
        $request->validate([
            'tanggal' => 'required|date',
            'harga' => 'required'
        ]);

        // dd($request->all());

        $tmpharga->tanggal = $request->tanggal;
        $tmpharga->harga = $request->harga;
        // dd($harga);
        $tmpharga->save();

        // $user->name = $request->name;
        // $user->username = $request->username;
        // $user->role = $request->role;
        // $user->save();

        return redirect()->route('tmpharga.index')->with('success', 'Data Berhasil diubah');
    }

    public function delete(Tmpharga $tmpharga){
        $tmpharga->delete();

        return redirect()->route('tmpharga.index')->with('success', 'Data Berhasil dihapus');
    }

}
