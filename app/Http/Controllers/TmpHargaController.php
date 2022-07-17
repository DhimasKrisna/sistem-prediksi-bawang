<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TmpHarga;
use Goutte\Client;


class TmpHargaController extends Controller
{
    //
    public function index()
    {
        $tmpharga = Tmpharga::orderBy('tanggal', 'desc')->get();

        $data = [
            'tmphargas' => $tmpharga
        ];
        
        return view('tmpharga.index', $data);
    }

    public function create()
    {
        $client = new Client();

        $crawler = $client->request('POST', 'https://siskaperbapo.jatimprov.go.id/produsen/tabel.nodesign/');
        

        $scrapsData = collect();

        $crawler->filter('tr')->each(function ($node) use ($scrapsData) {
            $scrapsData->push($node->text());
        });

        

        foreach($scrapsData as $i => $sc)
        {
            $hargas[$i] = explode(" ", $sc);
        }

        $harga = $hargas[1][8];
        
        $data = [
            'harga' => $harga * 1000
        ];

        return view('tmpharga.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'harga' => 'required'
        ]);
        $hargaLama = TmpHarga::where('tanggal', $request->tanggal->first());

        if($hargaLama){
            $hargaLama->tanggal = $request->tanggal;
            $hargaLama->harga = $request->harga;
            $hargaLama->save();
        }else{
            $harga = new Tmpharga;
        
            $harga->tanggal = $request->tanggal;
            $harga->harga = $request->harga;
            // dd($harga);
            $harga->save();
        }


        return redirect()->route('tmpharga.index')->with('success', 'Data Berhasil ditambahkan');
    }

    public function edit(Tmpharga $tmpharga)
    {
        // dd($tmpharga);

        $data = [
            'harga' => $tmpharga
        ];
        // dd($data);

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

    public function crawl(Request $request){
        if($request->tanggal){
            
            $dataFinalMapping = $this->scrap($request->tanggal);
            $data = [
                'tabelHarga' => $dataFinalMapping[1],
                'request' => $request
            ];
            
            return view('tmpharga.crawl', $data);

        }else{
            
            $data = [
                'request' => $request
            ];

            return view('tmpharga.crawl', $data);
        }
        
    }

    public function storeCrawl(Request $request){
        
        $request->validate([
            'tanggal' => 'required|date'
        ]);
        $dataFinalMapping = $this->scrap($request->tanggal);
        // dd($dataFinalMapping[1]);

        foreach($dataFinalMapping[1]['detail'] as $data){
            $hargaLama = TmpHarga::where('tanggal', $data['tanggal'])->first();

            if($data['harga']){
                if($hargaLama){
                    $hargaLama->harga = $data['harga'];
                    $hargaLama->save();
                }else{
                    $harga = new TmpHarga();
                    $harga->tanggal = $data['tanggal'];
                    $harga->harga = $data['harga'];
                    $harga->save();
                }
            }

            
        }

        return redirect()->route('tmpharga.index')->with('success', 'Data Berhasil di Crawling');
    }

    public function scrap($tanggal){
        $client = new Client();

            //scraping data
            $crawler = $client->request('GET', 'https://siskaperbapo.jatimprov.go.id/produsen/grafik/?tanggal='.$tanggal.'&bhnpokok=Bawang%20Merah');
            //https://siskaperbapo.jatimprov.go.id/produsen/grafik/?tanggal=2022-04-30&bhnpokok=Bawang%20Merah
            // dd($crawler);

            $scrapsData = collect();

            $crawler->filter('script')->each(function ($node) use ($scrapsData) {
                $scrapsData->push($node->text());
            });
            // dd($scrapsData[4]);

            $tmp = $scrapsData[4];
            $stringJsonFalse = substr($tmp,671,-530);
            // dd($stringJsonFalse);
            $stringA = substr($stringJsonFalse,0,193);
            $stringB = substr($stringJsonFalse,194,-3);
            $fullJson = $stringA . $stringB . "]}";
            // dd($fullJson);
            
            $dataJson = json_decode($fullJson);
            // dd($dataJson);

            //mapping data pasar
            $dataPasarMapping = [];
            foreach ($dataJson->cols as $i => $col) {
                if ($i > 0) {
                    $dataPasarMapping[] = [
                        'nama_pasar' => $col->label
                    ];
                }
            }

            //mapping data harga bawang per tanggal
            $dataHargaMapping = [];
            foreach ($dataJson->rows as $row) {
                foreach ($row->c as $i => $detail) {
                    if ($i > 0) {
                        $dataHargaMapping[$i - 1][] = [
                            'tanggal' => $row->c[0]->v,
                            'harga' => $detail->v
                        ];
                    }
                }
            }

            //mapping data pasar digabung data harga
            $dataFinalMapping = [];
            foreach ($dataPasarMapping as $i => $dataPasar) {
                $dataFinalMapping[] = [
                    'nama_pasar' => $dataPasar['nama_pasar'],
                    'detail' => $dataHargaMapping[$i]
                ];
            }
            // dd($dataFinalMapping[1]);
            return $dataFinalMapping;
    }

}
