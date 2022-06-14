@extends('template.template')
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif
<div class="card">
    <a href="{{route('artikel.create')}}" class="btn btn-primary">Tambah Artikel</a>
    <table class="table mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Judul</th>
                <th scope="col">Pengisi</th>
                <th scope="col">Isi</th>
                @if (auth()->user()->role == "admin")
                    <th scope="col">Action</th>
                @endif
                
            </tr>
        </thead>
        <tbody>
            @forelse ($artikels as $artikel)
            <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $artikel->judul }}</td>
                <td>{{ $artikel->pengisi }}</td>
                <td>{{ $artikel->isi }}</td>
                @if (auth()->user()->role == "admin")
                    <td>
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
@endsection