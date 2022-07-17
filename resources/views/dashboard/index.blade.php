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
    <h1 class="h3 mb-0 text-gray-800 flex-grow-1 bd-highlight">Halaman Dashboard</h1>
</div>

<div class="card mb-5">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Harga Bawang Merah</h6>
    </div>

    <div class="card-body">
        <table id="table_harga" class="table mt-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Minggu</th>
                    <th scope="col">Harga</th>
                    
                </tr>
            </thead>
            <tbody>
                @forelse ($hargas as $harga)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $harga->tanggal }}</td>
                    <td>{{ $harga->minggu }}</td>
                    <td>{{ $harga->harga }}</td>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
</div>

@if (auth()->user()->role == "admin")
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
        </div>
        <div class="card-body">
            <table class="table mt-2" id="table_user">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Role</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->role }}</td>
                        
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
@endif



@endsection

@section('customJs')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_harga').DataTable( {
                select: true,
                pageLength: 5
            } );

            $('#table_user').DataTable( {
                select: true,
                pageLength: 5
            } );
        } );
    </script>

@endsection
