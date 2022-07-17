@extends('template.template')
@section('customCSS')
    <!-- Custom styles Datatables-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif
<div class="d-flex bd-highlight mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-grow-1 bd-highlight">Halaman User</h1>

    @if (auth()->user()->role == 'admin')
        <a href="{{route('user.create')}}" class="btn btn-primary bd-highlight">Tambah User</a>  
    @endif
</div>

<div class="card">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
    </div>
    <div class="card-body">
        <table class="table mt-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                    @if (auth()->user()->role == "admin")
                        <th scope="col">Action</th>    
                    @endif
                    
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->role }}</td>
                    @if (auth()->user()->role == "admin")
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
                    @endif
                    
                </tr>
                @empty
                <tr>
                    <td colspan="5">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
</div>
@endsection

@section('customJs')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable( {
                select: true
            } );
        } );
    </script>

@endsection