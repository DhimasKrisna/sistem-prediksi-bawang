<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harga;
use App\Models\TmpHarga;
use Illuminate\Support\Carbon;

class HargaController extends Controller
{
    //
    public function index()
    {
        $harga = Harga::get();

        $data = [
            'hargas' => $harga
        ];
        
        return view('harga.index', $data);
    }
    
    public function create(Request $request)
    {
        if($request->tanggal_pilih){
            $tanggalSekarang = Carbon::parse($request->tanggal_pilih);
        } else {
            $tanggalSekarang = Carbon::now();
        }

        
        $tanggalAwal = $tanggalSekarang->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $tanggalAkhir = $tanggalSekarang->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');

        
        $tmpHarga = TmpHarga::whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])->get() ;
        $hargaTertinggi = $tmpHarga->max('harga');


        $data = [
            'hargaTertinggi' => $hargaTertinggi,
            'request' => $request
        ];


        
        return view('harga.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'harga' => 'required'
        ]);

        // dd($request->all());

        $tmp = Carbon::parse($request->tanggal);


        $harga = new Harga;
        $harga->tanggal = $request->tanggal;
        $harga->tahun = $tmp->year;
        $harga->bulan = $tmp->month;
        $harga->minggu = $tmp->weekOfYear;
        $harga->harga = $request->harga;
        $harga->pengisi = auth()->user()->id;
        // dd($harga);
        $harga->save();

        return redirect()->route('harga.index')->with('success', 'Data Berhasil ditambahkan');
    }

    public function edit(Harga $harga)
    {
        // dd($harga);

        $data = [
            'harga' => $harga
        ];
        return view('harga.edit', $data);
    }

    public function update(Request $request, Harga $harga)
    {
        //
        $request->validate([
            'tanggal' => 'required|date',
            'harga' => 'required'
        ]);

        // dd($request->all());

        $tmp = Carbon::parse($request->tanggal);
        $harga->tanggal = $request->tanggal;
        $harga->tahun = $tmp->year;
        $harga->bulan = $tmp->month;
        $harga->minggu = $tmp->weekOfYear;
        $harga->harga = $request->harga;
        $harga->pengisi = auth()->user()->id;
        // dd($harga);
        $harga->save();

        // $user->name = $request->name;
        // $user->username = $request->username;
        // $user->role = $request->role;
        // $user->save();

        return redirect()->route('harga.index')->with('success', 'Data Berhasil diubah');
    }

    public function delete(Harga $harga){
        $harga->delete();

        return redirect()->route('harga.index')->with('success', 'Data Berhasil dihapus');
    }

}
