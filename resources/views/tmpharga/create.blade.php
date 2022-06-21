@extends('template.template')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <label for="harga" class="form-label">Harga dari Pasar Sukomoro</label>
            <input type="text" class="form-control" id="harga_sekarang" value="{{$harga}}" disabled>
        </div>
        <div class="mb-3">
            <button onClick="ambilHarga()" type="button" class="btn btn-primary">Ambil Harga</button>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{route('tmpharga.store')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="tangal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{old('tanggal')}}>
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
    </div>
</div>
@endsection

@section('customJs')
    <script>
        function ambilHarga() {
            let harga = document.getElementById('harga_sekarang').value;
            document.getElementById('harga').value = harga;

            let hari = new Date();
            let tanggal = hari.getFullYear() + '-' + ('0' + (hari.getMonth()+1)).slice(-2) + '-' +  ('0' + hari.getDate()).slice(-2);
            
            document.getElementById('tanggal').value = tanggal;
        }
    </script>
@endsection