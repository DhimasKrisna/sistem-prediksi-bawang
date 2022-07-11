<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <!-- <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div> -->
            <div class="sidebar-brand-text mx-3">Sistem Prediksi Bawang Merah</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Halaman Utama</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Halaman
        </div>

        <!-- Nav Item - Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Grafik</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Tahun :</h6>
                    <a class="collapse-item" href="{{route('harga.index')}}?tahun=2019">2019</a>
                    <a class="collapse-item" href="{{route('harga.index')}}?tahun=2020">2020</a>
                    <a class="collapse-item" href="{{route('harga.index')}}?tahun=2021">2021</a>
                    <a class="collapse-item" href="{{route('harga.index')}}?tahun=2022">2022</a>
                    <div class="collapse-divider"></div>
                </div>
            </div>
        </li>

        <!-- Nav Item - TmpHarga -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('tmpharga.index')}}">
                <i class="fas fa-fw fa-coins"></i>
                <span>Semua Harga</span></a>
        </li>
        
        <!-- Nav Item - Peramalan -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('svr.index')}}">
                <i class="fas fa-fw fa-cog"></i>
                <span>Peramalan</span></a>
        </li>

        <!-- Nav Item - Artikel -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('artikel.index')}}">
                <i class="fas fa-fw fa-table"></i>
                <span>Artikel</span></a>
        </li>

        <!-- Nav Item - User -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('user.index')}}">
                <i class="fas fa-fw fa-user"></i>
                <span>User</span></a>
        </li>


        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>


    </ul>
    <!-- End of Sidebar -->