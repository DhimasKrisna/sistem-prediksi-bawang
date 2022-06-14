@extends('template.template')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('harga.store')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="tangal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" >
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