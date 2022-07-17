@extends('template.template')
@section('content')
    <div class="card mb-5">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Artikel</h6>
            <a href="{{route('artikel.index')}}" class="btn btn-primary">Kembali</a>
        </div>

        <div class="card-body">
            <h2 class="text-center text-dark">{{$artikel->judul}}</h2>
            <h4 class="text-center text-dark mb-3">Ditulis oleh : {{$artikel->getPengisi->username}}</h4>
            <p class="text-dark">{{$artikel->isi}}</p>
        </div>

        
    </div>
@endsection
