@extends('template.template')
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif
<div class="card">
    <a href="{{route('harga.create')}}" class="btn btn-primary">Tambah Harga</a>
    <table class="table mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Minggu</th>
                <th scope="col">Harga</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hargas as $harga)
            <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $harga->tanggal }}</td>
                <td>{{ $harga->minggu }}</td>
                <td>{{ $harga->harga }}</td>
                <td>
                    <a href="{{route('harga.edit',$harga->id)}}" class="btn btn-warning">Edit</a>

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
                            <form action="{{route('harga.delete',$harga->id)}}" method="post">
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