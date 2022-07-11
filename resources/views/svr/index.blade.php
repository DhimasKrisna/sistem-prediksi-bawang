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
    <h1 class="h3 mb-0 text-gray-800 flex-grow-1 bd-highlight">Halaman Peramalan</h1>
</div>

<div class="card mb-5">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Peramalan</h6>
    </div>

    <div class="card-body">
        <div class="progress d-none" id="progress-bar">
            <div id="loadbar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>

        <form id="form-predict" onSubmit="showProgresBar(event)" action="" method="get">
            @csrf
            <div class="mb-3">
                <label for="tangal" class="form-label">Pilih minggu data yang ingin Diramal</label>
            </div>
            <input type="hidden" id="minggu" name="minggu" value="">
            <div class="mb3">
                <button type="button" onclick="predictMinggu(1)" class="btn btn-primary">1 Minggu Depan</button>
                <button type="button" onclick="predictMinggu(2)" class="btn btn-primary">2 Minggu Depan</button>
                <button type="button" onclick="predictMinggu(3)" class="btn btn-primary">3 Minggu Depan</button>
            </div>
        </form>

        @if ($prediksi)
            <div class="m-0 font-weight-bold text-primary mt-5">
                <label for="tangal" class="form-label">Hasil Prediksi {{$minggu}} Minggu ke depan adalah {{$prediksi}}</label>
            </div>
        @endif
        
    </div>

    
</div>

<div class="card">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Harga Bawang Merah</h6>
    </div>

    <div class="card-body">
        <table id="table" class="table mt-2">
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

    <script>
        function showProgresBar(event){
            event.preventDefault();

            const progressBar = document.getElementById('progress-bar');
            progressBar.classList.remove("d-none");

            const loadBar = document.getElementById('loadbar');
            // console.log;
            
            setTimeout(function() {
                loadBar.style.width = "33%";
                setTimeout(function() {
                    loadBar.style.width = "66%";
                    setTimeout(function() {
                        loadBar.style.width = "100%";
                        setTimeout(function() {
                            loadBar.style.display =  "none";
                            document.getElementById('form-predict').submit();
                        }, 250);
                    }, 250);
                }, 250);
            }, 250); // WAIT 1 second
        }
    </script>

    <script>
        function predictMinggu(minggu){
            document.getElementById('minggu').value = minggu;

            const progressBar = document.getElementById('progress-bar');
            progressBar.classList.remove("d-none");

            const loadBar = document.getElementById('loadbar');
            // console.log;
            
            setTimeout(function() {
                loadBar.style.width = "33%";
                setTimeout(function() {
                    loadBar.style.width = "66%";
                    setTimeout(function() {
                        loadBar.style.width = "100%";
                        setTimeout(function() {
                            loadBar.style.display =  "none";
                            document.getElementById('form-predict').submit();
                        }, 250);
                    }, 250);
                }, 250);
            }, 250); // WAIT 1 second

            
        }
    </script>

@endsection
