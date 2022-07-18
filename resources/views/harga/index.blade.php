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
    <h1 class="h3 mb-0 text-gray-800 flex-grow-1 bd-highlight">Halaman Harga</h1>
    
    @if (auth()->user()->role == 'admin')
        <a href="{{route('harga.create')}}" class="btn btn-primary bd-highlight">Tambah Harga</a>
    @endif
</div>

<div class="card mb-5">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Grafik Bawang Merah</h6>
    </div>

    <div class="card-body">
        @if ($hargas->isNotEmpty())
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
            
        @else
            <h3 class="text-center" >Tidak ada data</h3>
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
                    @if (auth()->user()->role == "admin")
                        <th scope="col">Action</th>
                    @endif
                    
                </tr>
            </thead>
            <tbody>
                @forelse ($hargas as $harga)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ Illuminate\Support\Carbon::parse($harga->tanggal)->isoFormat('dddd, DD-MM-YYYY') }}</td>
                    <td>{{ $harga->minggu }}</td>
                    <td>{{ $harga->harga }}</td>
                    @if (auth()->user()->role == "admin")
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
                    @endif
                    
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

    <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>
    <script>
        $(function() {
            //fetch data chart
            $.ajax({
                url: "{{route('harga.chart', ['tahun' => $tahun])}}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    var data = data

                    console.log(data)

                    // Area Chart Example
                    var ctx = document.getElementById("myAreaChart");
                    var myLineChart = new Chart(ctx, {
                        type: 'line',
                        data: data,
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                }
                            },
                            scales: {
                                xAxes: [{
                                    time: {
                                        unit: 'date'
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        maxTicksLimit: 7
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        maxTicksLimit: 5,
                                        padding: 10,
                                    },
                                    gridLines: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2]
                                    }
                                }],
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: '#6e707e',
                                titleFontSize: 14,
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                intersect: false,
                                mode: 'index',
                                caretPadding: 10,
                                callbacks: {
                                    label: function(tooltipItem, chart) {
                                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                        return datasetLabel + ': ' + tooltipItem.yLabel;
                                    }
                                }
                            }
                        }
                    });
                }
            });
        });
    </script>

@endsection
