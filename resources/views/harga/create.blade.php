@extends('template.template')
@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <label for="harga" class="form-label">Harga Tertinggi Pada Minggu ini</label>
            <input type="text" class="form-control" id="harga_sekarang" value="{{$hargaTertinggi}}" disabled>
        </div>
        <div class="mb-3">
            <button onClick="ambilHarga()" type="button" class="btn btn-primary">Ambil Harga</button>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{route('harga.store')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="tangal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" onchange="gantiTanggal()" value="{{old('tanggal', $request->tanggal_pilih)}}" >
                @error('tanggal')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga" value="{{old('harga')}}">
                @error('harga')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            
            <div class="mb3">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
        <form id="pilih_minggu" action="{{route('harga.create')}}" method="GET">
            @csrf
            <input type="date" class="d-none" id="tanggal_pilih" name="tanggal_pilih">
        </form>
    </div>
</div>
@endsection

@section('customJs')
    <script>
        function ambilHarga() {
            let harga = document.getElementById('harga_sekarang').value;
            document.getElementById('harga').value = harga;

            const queryStrings = window.location.search;
            const urlParams = new URLSearchParams(queryStrings);

            const tanggal_pilih = urlParams.get('tanggal_pilih') ?? null;

            let hari = new Date();

            if(tanggal_pilih){
                hari = new Date(tanggal_pilih);
            }
            
            let tanggal = hari.getFullYear() + '-' + ('0' + (hari.getMonth()+1)).slice(-2) + '-' +  ('0' + hari.getDate()).slice(-2);
            
            document.getElementById('tanggal').value = tanggal;
        }

        function gantiTanggal(){
            let tanggal = document.getElementById('tanggal').value;
            document.getElementById('tanggal_pilih').value = tanggal;
            
            let form = document.getElementById('pilih_minggu');
            form.submit();
        }
    </script>
@endsection