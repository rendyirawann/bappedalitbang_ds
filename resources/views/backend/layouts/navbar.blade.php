<nav class="navbar navbar-expand-lg navbar-dark bg-default fixed-top" id="mainNav">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('udema/bappeda/bappeda.png') }}" data-retina="true" alt="Logo" width="36"> Admin
        Bappedalitbang
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
        data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">

        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="{{ url('admin/dashboard') }}">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Messages">
                <a class="nav-link" href="{{ url('admin/berita') }}">
                    <i class="fa fa-fw fa-book"></i>
                    <span class="nav-link-text">Berita Perencanaan</span>
                </a>
            </li>

            @if (auth()->user()->username === 'developer' || auth()->user()->username === 'admin')
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Unduhan">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseUnduhan"
                        data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-download"></i>
                        <span class="nav-link-text">Bappeda Unduhan</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseUnduhan">
                        <li><a href="{{ url('admin/unduhan') }}">Berkas Unduhan</a></li>
                        <li><a href="{{ url('admin/profil') }}">Berkas Profil</a></li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Galeri">
                    <a class="nav-link" href="{{ url('admin/galeri') }}">
                        <i class="fa fa-fw fa-image"></i>
                        <span class="nav-link-text">Galeri</span>
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Visi Misi">
                    <a class="nav-link" href="{{ url('admin/visimisi') }}">
                        <i class="fa fa-fw fa-bullseye"></i>
                        <span class="nav-link-text">Visi Misi</span>
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Struktur">
                    <a class="nav-link" href="{{ url('admin/struktur') }}">
                        <i class="fa fa-fw fa-users"></i>
                        <span class="nav-link-text">Struktur</span>
                    </a>
                </li>

                <li class="nav-header ms-3 mt-3 text-muted small font-weight-bold">ADMIN MENU</li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="User">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseProfile"
                        data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-user"></i>
                        <span class="nav-link-text">User</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseProfile">
                        <li><a href="{{ url('admin/user') }}">Data User</a></li>
                        <li><a href="{{ url('admin/pegawai') }}">Data Pegawai</a></li>
                    </ul>
                </li>
            @endif
        </ul>

        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell"></i>
                    <span class="d-lg-none">Notifikasi Baru
                        <span class="badge badge-pill badge-warning">{{ $countNotification ?? 0 }}</span>
                    </span>
                    <span class="indicator text-warning d-none d-lg-block">
                        <i class="fa fa-fw fa-circle"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header"> Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fa fa-book"></i> {{ $countBeritaBaru ?? 0 }} Berita Baru
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fa fa-book ml-4"></i> {{ $countBeritaReview ?? 0 }} Berita Review
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fa fa-user"></i>
                    <span class="d-lg-none"> Akun - {{ auth()->user()->username ?? 'Akun' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">Pengaturan Akun -
                        {{ auth()->user()->username ?? 'Akun' }}</span>
                    <div class="dropdown-divider"></div>
                    <a href="{{ url('admin/change-auth') }}" class="dropdown-item">
                        <i class="fa fa-key"></i> Ganti Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer" data-toggle="modal"
                        data-target="#logoutModal">
                        <i class="fa fa-power-off"></i> Keluar
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#logoutModal">
                    <i class="fa fa-fw fa-sign-out"></i>Logout</a>
            </li>
        </ul>

    </div>
</nav>
