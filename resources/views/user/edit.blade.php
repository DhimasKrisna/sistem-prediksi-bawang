@extends('template.template')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('user.update', $user->id)}}" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{old('name') ?? $user->name}}">
                @error('name')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{old('username') ?? $user->username}}">
                @error('username')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Sebagai</label>
                <select class="form-select" aria-label="Default select example" id="role" name="role">
                    <option selected>-Pilih Role-</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                  </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                @error('password')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
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