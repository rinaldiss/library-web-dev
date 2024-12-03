
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIMPERPUS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        BUKU INDUK
    </div>

    <li class="nav-item  {{ Request::is('admin/peraturan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.regulation') }}">
            <i class="fas fa-fw fa-gavel"></i>
            <span>Peraturan</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/majalah*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.magazine') }}">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Majalah</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/buku*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.book') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Buku</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item {{ Request::is('admin/peminjaman-buku*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.loan') }}">
            <i class="fas fa-fw fa-id-card"></i>
            <span>Peminjaman Buku</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/daftar-kunjungan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.visitor') }}">
            <i class="fas fa-fw fa-walking"></i>
            <span>Daftar Kunjungan</span>
        </a>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li> --}}

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>