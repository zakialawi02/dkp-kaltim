<!-- ======= Sidebar ======= -->
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <a class="nav-link pt-3" href="<?= base_url(); ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-house-door-fill"></i></div>
                    Beranda
                </a>
                <a class="nav-link" href="/dashboard">
                    <div class="sb-nav-link-icon"><i class="bi bi-grid-fill"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="/map">
                    <div class="sb-nav-link-icon"><i class="bi bi-pin-map-fill"></i></div>
                    Peta
                </a>

                <?php if (in_groups('SuperAdmin') || in_groups('Admin')) :; ?>
                    <div class="sb-sidenav-menu-heading">Data</div>

                    <a class="nav-link collapsed" href="/admin/features" data-bs-toggle="collapse" data-bs-target="#collapseGeojson" aria-expanded="false" aria-controls="collapseGeojson">
                        <div class="sb-nav-link-icon"><i class="bi bi-archive-fill"></i></div>
                        Features
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseGeojson" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <div class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="/admin/features/tambah">Add Data</a>
                            <a class="nav-link" href="/admin/features">Semua Data</a>
                        </div>
                    </div>

                    <a class="nav-link collapsed" href="/admin/data/data-permohonan" data-bs-toggle="collapse" data-bs-target="#collapseKafe" aria-expanded="false" aria-controls="collapseKafe">
                        <div class="sb-nav-link-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
                        Informasi Ruang Laut
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseKafe" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <div class="sb-sidenav-menu-nested nav">
                            <!-- <a class="nav-link" href="/admin/data/data-permohonan/tambah">Add Data</a> -->
                            <a class="nav-link" href="/admin/data/data-permohonan">Semua Data</a>
                        </div>
                    </div>

                    <a class="nav-link collapsed" href="/admin/features" data-bs-toggle="collapse" data-bs-target="#collapsePending" aria-expanded="false" aria-controls="collapsePending">
                        <div class="sb-nav-link-icon"><i class="bi bi-hourglass-split"></i></div>
                        Data Masuk/Baru
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePending" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <div class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="/admin/pending">Semua Data</a>
                        </div>
                    </div>
                <?php endif ?>

                <div class="sb-sidenav-menu-heading">Pengaturan</div>

                <?php if (in_groups('SuperAdmin') || in_groups('Admin')) : ?>
                    <a class="nav-link" href="/user/manajemen">
                        <div class="sb-nav-link-icon"><i class="bi bi-person-lines-fill"></i></div>
                        Kelola Pengguna
                    </a>
                    <a class="nav-link" href="/admin/setting">
                        <div class="sb-nav-link-icon"><i class="bi bi-sliders"></i></div>
                        Peta
                    </a>
                <?php endif ?>

                <a class="nav-link" href="/kontak">
                    <div class="sb-nav-link-icon"><i class="bi bi-envelope-fill"></i></div>
                    Kontak Kami
                </a>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <span><?= user()->username; ?></span>
        </div>
    </nav>
</div>