<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <img style="width:auto; height:50px;" src="{{ asset('landing/login/img/logo.png') }}" alt="logo">
        </div>
        <div class="sidebar-brand-text mx-3">
           {{env('APP_NAME')}}
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @if(Auth::user()->level == 'Admin')
    <li class="nav-item {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master Data
    </div>
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item {{ (request()->is('admin/nasabah')) ? 'active' : '' }}{{ (request()->is('admin/nasabah/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{url('admin/nasabah')}}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Nasabah</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/pinjaman')) ? 'active' : '' }}{{ (request()->is('admin/pinjaman/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{url('admin/pinjaman')}}">
            <i class="fas fa-fw fa-money"></i>
            <span>Data Pinjaman</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/simpanan')) ? 'active' : '' }}{{ (request()->is('admin/simpanan/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{url('admin/simpanan')}}">
            <i class="fas fa-fw fa-money"></i>
            <span>Data Simpanan</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/pembayaran')) ? 'active' : '' }}{{ (request()->is('admin/pembayaran/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{url('admin/pembayaran')}}">
            <i class="fas fa-fw fa-money"></i>
            <span>Data Pembayaran</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/biaya')) ? 'active' : '' }}{{ (request()->is('admin/biaya/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{url('admin/biaya')}}">
            <i class="fas fa-fw fa-dollar"></i>
            <span>Biaya Koperasi</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/shu')) ? 'active' : '' }}{{ (request()->is('admin/shu/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{url('admin/shu')}}">
            <i class="fas fa-fw fa-coins"></i>
            <span>SHU Koperasi</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/pengaturan')) ? 'active' : '' }}{{ (request()->is('admin/pengaturan/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{url('admin/pengaturan')}}">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Pengaturan</span>
        </a>
    </li>
    @elseif(Auth::user()->level == 'Pimpinan')
    <li class="nav-item {{ (request()->is('nasabah/dashboard')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('nasabah.dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master Data
    </div>
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item {{ (request()->is('nasabah/pinjaman')) ? 'active' : '' }}{{ (request()->is('pegawai/pinjaman/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{url('nasabah/pinjaman')}}">
            <i class="fas fa-fw fa-folder"></i>
            <span>Data Pinjaman</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('nasabah/pinjaman')) ? 'active' : '' }}{{ (request()->is('pegawai/pinjaman/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{url('nasabah/pinjaman')}}">
            <i class="fas fa-fw fa-folder"></i>
            <span>Data Simpanan</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('nasabah/profil')) ? 'active' : '' }}{{ (request()->is('nasabah/profil/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{url('nasabah/profil')}}">
            <i class="fas fa-fw fa-user"></i>
            <span>Profile</span>
        </a>
    </li>
    @endif
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    <!-- Sidebar Message ->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
            </div>
           <-- Sidebar Message -->

</ul>
<!-- End of Sidebar -->