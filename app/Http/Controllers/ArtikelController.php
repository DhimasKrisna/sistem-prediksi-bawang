<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    //
    public function index()
    {
        $artikel = Artikel::with(["getPengisi"])->get();

        $data = [
            'artikels' => $artikel
        ];

        return view('artikel.index', $data);
    }

    public function baca(Artikel $artikel)
    {
        $artikel = Artikel::with(["getPengisi"])->find($artikel->id);

        $data = [
            'artikel' => $artikel
        ];

        return view('artikel.baca', $data);
    }

    public function create()
    {
        return view('artikel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required'
        ]);

        // dd($request->all());



        $artikel = new Artikel;
        $artikel->judul = $request->judul;
        $artikel->isi = $request->isi;
        $artikel->pengisi = auth()->user()->id;
        // dd($artikel);
        $artikel->save();

        return redirect()->route('artikel.index')->with('success', 'Artikel Berhasil ditambahkan');
    }

    public function edit(Artikel $artikel)
    {
        // dd($artikel);

        $data = [
            'artikel' => $artikel
        ];
        return view('artikel.edit', $data);
    }

    public function update(Request $request, Artikel $artikel)
    {
        //
        $request->validate([
            'judul' => 'required',
            'isi' => 'required'
        ]);

        // dd($request->all());

        $artikel->judul = $request->judul;
        $artikel->isi = $request->isi;
        $artikel->pengisi = auth()->user()->id;
        // dd($artikel);
        $artikel->save();

        return redirect()->route('artikel.index')->with('success', 'Artikel Berhasil diubah');
    }

    public function delete(Artikel $artikel)
    {
        $artikel->delete();

        return redirect()->route('artikel.index')->with('success', 'Artikel Berhasil dihapus');
    }
}
