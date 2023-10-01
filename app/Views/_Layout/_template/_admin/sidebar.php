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
                <a class="nav-link" href="/peta">
                    <div class="sb-nav-link-icon"><i class="bi bi-pin-map-fill"></i></div>
                    Cek Kesesuaian
                </a>

                <?php if (in_groups('SuperAdmin') || in_groups('Admin')) :; ?>
                    <div class="sb-sidenav-menu-heading">Data</div>

                    <a class="nav-link collapsed" href="/admin/data/permohonan/disetujui/semua" data-bs-toggle="collapse" data-bs-target="#collapseKafe" aria-expanded="false" aria-controls="collapseKafe">
                        <div class="sb-nav-link-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
                        Informasi Ruang Laut
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-caret-down-fill"></i></div>
                    </a>
                    <div class="collapse" id="collapseKafe" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <div class="sb-sidenav-menu-nested nav">
                            <!-- <a class="nav-link" href="/admin/data/permohonan/disetujui/semua/tambah">Add Data</a> -->
                            <a class="nav-link" href="/admin/data/permohonan/disetujui/semua">Semua Data Disetujui</a>
                            <a class="nav-link" href="/admin/data/permohonan/disetujui/terlampir">Data Disetujui Dengan Lampiran</a>
                            <a class="nav-link" href="/admin/data/permohonan/disetujui/">Data Disetujui Tanpa Lampiran</a>
                            <a class="nav-link" href="/admin/data/permohonan/tidak-disetujui/semua">Semua Data Tidak Disetujui</a>
                        </div>
                    </div>

                    <a class="nav-link collapsed" href="/admin/data/permohonan/masuk" data-bs-toggle="collapse" data-bs-target="#collapsePending" aria-expanded="false" aria-controls="collapsePending">
                        <div class="sb-nav-link-icon"><i class="bi bi-hourglass-split"></i></div>
                        Data Masuk/Baru
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-caret-down-fill"></i></div>
                    </a>
                    <div class="collapse" id="collapsePending" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <div class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="/admin/data/permohonan/masuk">Semua Data</a>
                        </div>
                    </div>

                    <!-- <a class="nav-link" href="/admin/hide">
                        <div class="sb-nav-link-icon"><i class="bi bi-gear"></i></div>
                        Kesesuaian
                    </a> -->
                <?php endif ?>

                <div class="sb-sidenav-menu-heading">Pengaturan</div>

                <?php if (in_groups('SuperAdmin')) : ?>
                    <a class="nav-link" href="/admin/dataModul">
                        <div class="sb-nav-link-icon"><i class="bi bi-file-pdf-fill"></i></div>
                        Modul
                    </a>
                    <a class="nav-link collapsed" href="/admin/data/permohonan/masuk" data-bs-toggle="collapse" data-bs-target="#collapseKesesuai" aria-expanded="false" aria-controls="collapseKesesuai">
                        <div class="sb-nav-link-icon"><i class="bi bi-collection"></i></div>
                        Kesesuaian
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-caret-down-fill"></i></div>
                    </a>
                    <div class="collapse" id="collapseKesesuai" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <div class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="/admin/kegiatan">Data Kegiatan</a>
                        </div>
                    </div>
                    <div class="collapse" id="collapseKesesuai" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <div class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="/admin/zona">Data Zona</a>
                        </div>
                    </div>
                    <div class="collapse" id="collapseKesesuai" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <div class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="/admin/kawasan">Data Kawasan</a>
                        </div>
                    </div>
                    <div class="collapse" id="collapseKesesuai" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <div class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="/admin/kesesuaian"> Data Kesesuaian</a>
                        </div>
                    </div>
                    <a class="nav-link" href="/user/kelola">
                        <div class="sb-nav-link-icon"><i class="bi bi-person-lines-fill"></i></div>
                        Kelola Pengguna
                    </a>
                <?php endif ?>

                <?php if (in_groups('SuperAdmin') || in_groups('Admin')) : ?>
                    <a class="nav-link" href="/admin/setting">
                        <div class="sb-nav-link-icon"><i class="bi bi-sliders"></i></div>
                        Peta
                    </a>
                <?php endif ?>

                <hr>
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