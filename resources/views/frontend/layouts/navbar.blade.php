<!-- Navbar & Hero Start -->
<nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0 {{ Route::currentRouteName() !== 'home' ? 'opaque' : '' }}">
    <a href="" class="navbar-brand p-0">
        <img src="" id="site_logo" height="150px" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">
            <a href="/" class="nav-item nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">Home</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Profil</a>
                <div class="dropdown-menu m-0">
                    <a href="feature.html" class="dropdown-item">Sambutan</a>
                    <a href="product.html" class="dropdown-item">Struktur Organisasi</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Bidang</a>
                <div class="dropdown-menu m-0">
                    <a href="feature.html" class="dropdown-item">Bidang 1</a>
                    <a href="product.html" class="dropdown-item">Bidang 2</a>
                </div>
            </div>
            <a href="{{ route('berita.index') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'frontend.news.index' ? 'active' : '' }}">Berita</a>
            <a href="{{ route('unduhan.index') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'frontend.download.index' ? 'active' : '' }}">Unduhan</a>
            <a href="{{ route('galeri.index') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'frontend.galery.index' ? 'active' : '' }}">Galeri</a>
            <a href="" class="nav-item nav-link">Hubungi Kami</a>
        </div>
    </div>
</nav>
<!-- Navbar & Hero End -->
