@extends('template.template')
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif
<div class="card">
    <a href="{{route('user.create')}}" class="btn btn-primary">Tambah User</a>
    <table class="table mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Username</th>
                <th scope="col">Role</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="{{route('user.edit', $user->id)}}" class="btn btn-warning">Edit</a>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-hapus-{{$user->id}}">
                        Hapus
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="modal-hapus-{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            Apakah anda yakin akan menghapus user ini?
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="{{route('user.delete', $user->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection