<?php

namespace App\Http\Controllers;

use App\Models\Harga;
use Illuminate\Http\Request;
use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;


class SvrController extends Controller
{
    //
    public function index(){
        $hargas = Harga::get();
        // dd($hargas);

        $samples = [];
        $targets = [];

        foreach($hargas as $harga){
            $samples[] = [$harga->minggu, $harga->bulan, $harga->tahun];
            $targets[] = $harga->harga;
        }
        // dd($samples, $targets);
        // $samples = [[60], [61], [62], [63], [65]];
        // $targets = [3.1, 3.6, 3.8, 4, 4.1];

        // $regression = new SVR(Kernel::RBF, $degree = 3, $epsilon=0.01, $cost=1000);

        $regression = new SVR(Kernel::RBF, $degree = 3, $epsilon=0.01, $cost=0.00007);

        // $regression = new SVR(Kernel::RBF);
        $regression->train($samples, $targets);

        dd($regression->predict([25, 6, 2022]));
    }
}
