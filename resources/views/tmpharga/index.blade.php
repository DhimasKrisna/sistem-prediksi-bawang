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
    <h1 class="h3 mb-0 text-gray-800 flex-grow-1 bd-highlight">Halaman Semua Harga Bawang Merah</h1>

    @if (auth()->user()->role == 'admin')
        <a class="btn btn-primary ml-2 bd-highlight" href="{{route('tmpharga.create')}}">Tambah Harga</a>
        <a class="btn btn-danger ml-2 bd-highlight" href="{{route('tmpharga.crawl')}}">Crawling Harga</a>    
    @endif
    
</div>

<div class="card pd-2">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Semua Data Harga</h6>
    </div>
    <div class="card-body">
        <table id="table" class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Harga</th>
                    @if (auth()->user()->role == "admin")
                        <th scope="col">Action</th>
                    @endif
                    
                </tr>
            </thead>
            <tbody>
                @forelse ($tmphargas as $harga)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $harga->tanggal->isoFormat('dddd, DD-MM-YYYY') }}</td>
                    <td>{{ $harga->harga }}</td>
                    @if (auth()->user()->role == "admin")
                        <td>
                            <a href="{{route('tmpharga.edit',$harga->id)}}" class="btn btn-warning">Edit</a>
    
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-hapus-{{$harga->id}}">
                                Hapus
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="modal-hapus-{{$harga->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Harga</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    Apakah anda yakin akan menghapus data ini?
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{route('tmpharga.delete',$harga->id)}}" method="post">
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