<?php

namespace App\Http\Controllers;

use App\Models\Harga;
use App\Models\TmpHarga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;


class SvrController extends Controller
{
    //
    public function index(Request $request){
        

        $hargaTable = Harga::where('tahun', Carbon::now()->year)->orderBy('minggu', 'desc')->get();

        

        if($request->minggu){
            // $hargas = Harga::where('tahun', Carbon::now()->year)->orderBy('minggu', 'desc')->get();

            // $samples = [];
            // $targets = [];

            // foreach($hargas as $harga){
            //     $samples[] = [$harga->minggu, $harga->bulan, $harga->tahun];
            //     $targets[] = $harga->harga;
            // }

            //2 test

            $hargas = TmpHarga::orderBy('tanggal', 'desc')->limit(60)->get();

            $samples = [];
            $targets = [];

            foreach($hargas as $harga ){
                $tanggal = Carbon::parse($harga->tanggal);
                $samples[] = [$tanggal->weekOfYear, $tanggal->year, $tanggal->month];
                $targets[] = $harga->harga;
            }
            //2 test

            //test mape

            // $hargas = TmpHarga::where('tanggal', '<' , '2021-01-11' )->orderBy('tanggal', 'desc')->limit(60)->get();
            //

            // $samples = [];
            // $targets = [];

            // foreach($hargas as $harga ){
            //     $tanggal = Carbon::parse($harga->tanggal);
            //     $samples[] = [$tanggal->weekOfYear, $tanggal->year, $tanggal->month];
            //     $targets[] = $harga->harga;
            // }

            //

            
            
            // $regression = new SVR(Kernel::RBF, $degree = 3, $epsilon=0.01, $cost=1000);

            $regression = new SVR(Kernel::RBF, $degree = 3, $epsilon=0.01, $cost=0.00007);

            // $regression = new SVR(Kernel::RBF);
            $regression->train($samples, $targets);

            //test mape
            // $tanggalPrediksi = Carbon::createFromFormat('Y-m-d', '2021-01-11')->addWeek($request->minggu);
            // $mingguPrediksi = $tanggalPrediksi->weekOfYear;
            // $tahunPrediksi = $tanggalPrediksi->year;
            // $bulanPrediksi = $tanggalPrediksi->month;

            // // dd($mingguPrediksi, $tahunPrediksi, $bulanPrediksi);
            // $prediksi = $regression->predict([$mingguPrediksi, $bulanPrediksi, $tahunPrediksi]);
            // dd($prediksi);

            //

            // dd($regression->predict([29, 7, 2022]));
            
            // $tanggalPrediksi = Carbon::now()->addWeek($request->minggu);
            // $mingguPrediksi = $tanggalPrediksi->weekOfYear;
            // $tahunPrediksi = $tanggalPrediksi->year;
            // $bulanPrediksi = $tanggalPrediksi->month;

            // // dd($mingguPrediksi, $tahunPrediksi, $bulanPrediksi);
            // $prediksi = $regression->predict([$mingguPrediksi, $bulanPrediksi, $tahunPrediksi]);

            //2

            $tanggalPrediksi = Carbon::now()->addWeek($request->minggu);
            $mingguPrediksi = $tanggalPrediksi->weekOfYear;
            $tahunPrediksi = $tanggalPrediksi->year;
            $bulanPrediksi = $tanggalPrediksi->month;

            // dd($mingguPrediksi, $tahunPrediksi, $bulanPrediksi);
            $prediksi = $regression->predict([$mingguPrediksi, $bulanPrediksi, $tahunPrediksi]);

            //

            $data = [
                'hargas' => $hargaTable,
                'prediksi' => $prediksi,
                'minggu' => $request->minggu
            ];

            return view('svr.index', $data);

        }else {
            $data = [
                'hargas' => $hargaTable,
                'prediksi' => null
            ];
            return view('svr.index', $data);
        }
        
    }
}
