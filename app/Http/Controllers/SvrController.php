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

            //2 test Benar

            $hargas = TmpHarga::orderBy('tanggal', 'desc')->limit(60)->get();

            $samples = [];
            $targets = [];

            foreach($hargas as $harga ){
                $tanggal = Carbon::parse($harga->tanggal);
                $samples[] = [$tanggal->weekOfYear, $tanggal->year, $tanggal->month];
                $targets[] = $harga->harga;
            }
            //2 test Benar

            // // TEST MAPE

            // $hargas = TmpHarga::where('tanggal', '<' , '2022-08-8' )->orderBy('tanggal', 'desc')->limit(60)->get();
            

            // $samples = [];
            // $targets = [];

            // foreach($hargas as $harga ){
            //     $tanggal = Carbon::parse($harga->tanggal);
            //     $samples[] = [$tanggal->weekOfYear, $tanggal->year, $tanggal->month];
            //     $targets[] = $harga->harga;
            // }

            // // TEST MAPE

            // $regression = new SVR(Kernel::RBF, $degree = 3, $epsilon=0.01, $cost=1000);

            $regression = new SVR(Kernel::RBF, $degree = 3, $epsilon=0.01, $cost=0.00007);

            // $regression = new SVR(Kernel::RBF);
            $regression->train($samples, $targets);

            // //TEST MAPE
            // $tanggalPrediksi = Carbon::createFromFormat('Y-m-d', '2021-08-8')->addWeek($request->minggu);
            // $mingguPrediksi = $tanggalPrediksi->weekOfYear;
            // $tahunPrediksi = $tanggalPrediksi->year;
            // $bulanPrediksi = $tanggalPrediksi->month;

            // // dd($mingguPrediksi, $tahunPrediksi, $bulanPrediksi);
            // $prediksi = $regression->predict([$mingguPrediksi, $bulanPrediksi, $tahunPrediksi]);
            

            // //TEST MAPE

            //2

            $tanggalPrediksi = Carbon::now()->addWeek($request->minggu);
            $mingguPrediksi = $tanggalPrediksi->weekOfYear;
            $tahunPrediksi = $tanggalPrediksi->year;
            $bulanPrediksi = $tanggalPrediksi->month;

            // dd($mingguPrediksi, $tahunPrediksi, $bulanPrediksi);
            $prediksi = $regression->predict([$mingguPrediksi, $bulanPrediksi, $tahunPrediksi]);

            //2

            //revisi
            $checkPrediksi = abs($prediksi-$hargas->first()->harga);

            if($checkPrediksi > 5000){
                $max = $prediksi-$hargas->first()->harga + 5000;
                $min = $prediksi-$hargas->first()->harga - 5000;

                $hargasRange = TmpHarga::whereBetween('harga', [$min,$max])->orderBy('tanggal', 'desc')->limit(60)->get();
                // dd($hargasRange);

                // //TEST MAPE
                // $hargasRange = TmpHarga::where('tanggal', '<' , '2022-08-8' )->whereBetween('harga', [$min,$max])->orderBy('tanggal', 'desc')->limit(60)->get();

                // //TEST MAPE

                $samples = [];
                $targets = [];

                foreach($hargasRange as $harga ){
                    $tanggal = Carbon::parse($harga->tanggal);
                    $samples[] = [$tanggal->weekOfYear, $tanggal->year, $tanggal->month];
                    $targets[] = $harga->harga;
                }

                $regression->train($samples, $targets);
                $prediksi = $regression->predict([$mingguPrediksi, $bulanPrediksi, $tahunPrediksi]);
            }

            // dd($prediksi);


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
