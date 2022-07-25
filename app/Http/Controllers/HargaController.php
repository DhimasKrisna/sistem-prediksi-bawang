<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harga;
use App\Models\TmpHarga;
use Illuminate\Support\Carbon;

class HargaController extends Controller
{
    //
    public function index(Request $request)
    {
        if($request->tahun){
            $harga = Harga::where('tahun', $request->tahun)->orderBy('minggu', 'asc')->get();
        }else{
            $harga = Harga::get();
        }
        
        

        $data = [
            'hargas' => $harga,
            'tahun' => $request->tahun
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
        $harga->user_id = auth()->user()->id;
        // dd($harga);
        $harga->save();

        return redirect()->route('harga.index',"?tahun=2022")->with('success', 'Data Berhasil ditambahkan');
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
        $harga->user_id = auth()->user()->id;
        // dd($harga);
        $harga->save();

        // $user->name = $request->name;
        // $user->username = $request->username;
        // $user->role = $request->role;
        // $user->save();

        return redirect()->route('harga.index',"?tahun=2022")->with('success', 'Data Berhasil diubah');
    }

    public function delete(Harga $harga){
        $harga->delete();

        return redirect()->route('harga.index',"?tahun=2022")->with('success', 'Data Berhasil dihapus');
    }

    public function chart(Request $request){
        
        $hargas = Harga::where('tahun', $request->tahun)->orderBy('minggu', 'asc')->get();
        


        $labels = [];
        $data = [];

        foreach ($hargas as $harga) {
            $labels[] = $harga->minggu;
            $data[] = $harga->harga;
        }

        $response = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => "Harga Bawang Merah",
                    'lineTension' => 0.3,
                    'backgroundColor' => "rgba(78, 115, 223, 0.05)",
                    'borderColor' => "rgba(78, 115, 223, 1)",
                    'pointRadius' => 3,
                    'pointBackgroundColor' => "rgba(78, 115, 223, 1)",
                    'pointBorderColor' => "rgba(78, 115, 223, 1)",
                    'pointHoverRadius' => 3,
                    'pointHoverBackgroundColor' => "rgba(78, 115, 223, 1)",
                    'pointHoverBorderColor' => "rgba(78, 115, 223, 1)",
                    'pointHitRadius' => 10,
                    'pointBorderWidth' => 2,
                    'data' => $data
                ]
            ],
        ];

        return response()->json($response);
    }

}
