@extends('template.template')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('artikel.update',$artikel->id)}}" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{old('judul', $artikel->judul)}}">
                @error('judul')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="isi" class="form-label">Isi</label>
                <textarea class="form-control" id="isi" name="isi" rows="3">{{old('isi', $artikel->isi)}}</textarea>
                @error('isi')
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