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
    <h1 class="h3 mb-0 text-gray-800 flex-grow-1 bd-highlight">Halaman Artikel</h1>
    
    @if (auth()->user()->role == 'admin')
        <a href="{{route('artikel.create')}}" class="btn btn-primary bd-highlight">Tambah Artikel</a>    
    @endif
</div>

<div class="card">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Artikel</h6>
    </div>
    <div class="card-body">
        <table id="table" class="table mt-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul</th>
                    <th scope="col">User Pengisi</th>
                    <th scope="col">Isi</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($artikels as $artikel)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $artikel->judul }}</td>
                    <td>{{ $artikel->getUser->username }}</td>
                    <td style="max-width:300px" >{{ Illuminate\Support\Str::words($artikel->isi, 20)."..."  }}</td>
                        <td>
                            <a href="{{route('artikel.baca',$artikel->id)}}" class="btn btn-primary">Lihat</a>
                            @if (auth()->user()->role == "admin")
                                <a href="{{route('artikel.edit',$artikel->id)}}" class="btn btn-warning">Edit</a>
        
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-hapus-{{$artikel->id}}">
                                    Hapus
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="modal-hapus-{{$artikel->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Artikel</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        Apakah anda yakin akan menghapus Artikel ini?
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{route('artikel.delete',$artikel->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            @endif
                            
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