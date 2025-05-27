<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ url('/dashboard') }}" class="b-brand text-primary">
                <img src="{{ asset('assets/images/logo-dark.svg') }}" class="img-fluid logo-lg" alt="logo">
                {{-- <img src="{{ asset('frontend/img/logo3.png') }}" alt="Logo" style="height: 50px;"> --}}
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{ url('/dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Beranda</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Master Data</label>
                    <i class="ti ti-dashboard"></i>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-files"></i></span>
                        <span class="pc-mtext">Manajemen Website</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link" href="">
                                Identitas Website
                            </a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('banner.index') }} ">
                                Slider/Banner
                            </a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link" href="">
                                Logo & Favicon
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-files"></i></span>
                        <span class="pc-mtext">Manajemen Data</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('news.index') }}">
                                Berita
                            </a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('gallery.index') }}">
                                Galeri
                            </a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link" href="">
                                Unduhan
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pc-item">
                    <a href="" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-id"></i></span>
                        <span class="pc-mtext">Agenda</span>
                    </a>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-files"></i></span>
                        <span class="pc-mtext">Struktur Organisasi</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('category.index') }}">
                                Kategori
                            </a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('organizations.index') }}">
                                Daftar Anggota
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pc-item">
                    <a href="" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Bidang Kantor</span>
                    </a>
                </li>
                @hasrole('superadmin')
                    <li class="pc-item pc-caption">
                        <label>Manajemen Aplikasi</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    <li class="pc-item">
                        <a href="" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-receipt"></i></span>
                            <span class="pc-mtext">Log Aktivitas</span>
                        </a>
                    </li>
                @endhasrole
            </ul>
        </div>
    </div>
</nav>
