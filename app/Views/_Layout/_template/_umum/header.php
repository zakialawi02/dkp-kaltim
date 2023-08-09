<!-- ======= Header ======= -->
<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 px-4 px-lg-5">
    <a href="/" class="navbar-brand d-flex align-items-center">
        <h2 class="navbar-brand d-flex align-items-center m-0 text-primary navlogo"><img class="img-fluid navbar-logo me-2" src="/img/logo navbar.png" alt="DINAS KELAUTAN DAN PERIKANAN PROVINSI KALIMANTAN TIMUR" style="max-width: 15rem;"></h2>
    </a>
    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-4 py-lg-0">
            <a href="<?= base_url(); ?>/#home" class="nav-item nav-link active">Beranda</a>
            <a href="/map" class="nav-item nav-link">Cek Kesesuaian</a>
            <a href="/#about" class="nav-item nav-link">Tentang</a>
            <a href="/kontak" class="nav-item nav-link">Kontak</a>


            <?php if (logged_in()) : ?>
                <a class="nav-item nav-link auth" href="/dashboard"><span>Dashboard</span></a>
                <a class="nav-item nav-link auth" href="<?= base_url('logout'); ?>"><span>Log Out <i class="bi bi-box-arrow-right"></i></span></a>
            <?php else : ?>
                <a class="nav-item nav-link auth" href="/login"><span>Login <i class="bi bi-box-arrow-right"></i></span></a>
            <?php endif ?>
        </div>
    </div>
    </div>
</nav>
<!-- Navbar End -->