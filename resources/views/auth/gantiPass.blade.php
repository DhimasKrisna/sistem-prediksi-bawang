@extends('template.template')
@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{route('login.gantiPassAct')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{auth()->user()->username}}" disabled>
            </div>
            <div class="mb-3">
                <label for="password_lama" class="form-label">Password Lama</label>
                <input type="password" class="form-control" id="password_lama" name="password_lama">
                @error('password_lama')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="password" name="password">
                @error('password')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
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