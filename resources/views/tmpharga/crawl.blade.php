@extends('template.template')
@section('customCSS')
    <!-- Custom styles Datatables-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="progress d-none" id="progress-bar">
            <div id="loadbar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>
        <form id="form-crawl" onSubmit="showProgresBar(event)" action="{{route('tmpharga.crawl')}}" method="get">
            @csrf
            <div class="mb-3">
                <label for="tangal" class="form-label">Pilih tanggal terakhir data yang diambil</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{old('tanggal', $request->tanggal)}}">
                @error('tanggal')
                    <small class="text-danger"></small>
                @enderror
            </div>
            <div class="mb3">
                <button type="submit" class="btn btn-primary">Mulai Crawling</button>
            </div>
        </form>
    </div>
</div>

@if ($request->tanggal)
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Crawling Data</h6>
            <form action="{{route('tmpharga.storeCrawl')}}" method="POST">
                @csrf
                <input type="hidden" name="tanggal" value="{{$request->tanggal}}">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </form>
        </div>
        <div class="card-body">
            
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tabelHarga['detail'] as $harga)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($harga['tanggal'])->isoFormat('dddd, DD-MM-YYYY') }}</td>
                        <td>{{ $harga['harga'] ?? 'Tidak ada Data' }}</td>
                        
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection

@section('customJs')
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
                            document.getElementById('form-crawl').submit();
                        }, 250);
                    }, 250);
                }, 250);
            }, 250); // WAIT 1 second
        }
    </script>

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
