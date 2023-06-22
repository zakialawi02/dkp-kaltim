<!-- ======= Sidebar ======= -->
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <a class="nav-link pt-3" href="<?= base_url(); ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-house-door-fill"></i></div>
                    HOME
                </a>
                <a class="nav-link" href="/dashboard">
                    <div class="sb-nav-link-icon"><i class="bi bi-grid-fill"></i></div>
                    Dashboard
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
                            <a class="nav-link" href="/admin/features">All Data</a>
                        </div>
                    </div>

                    <a class="nav-link collapsed" href="/admin/data/data-perizinan" data-bs-toggle="collapse" data-bs-target="#collapseKafe" aria-expanded="false" aria-controls="collapseKafe">
                        <div class="sb-nav-link-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
                        Perizinan
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseKafe" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <div class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="/admin/data/data-perizinan/tambah">Add Data</a>
                            <a class="nav-link" href="/admin/data/data-perizinan">All Data</a>
                        </div>
                    </div>

                    <a class="nav-link collapsed" href="/admin/features" data-bs-toggle="collapse" data-bs-target="#collapsePending" aria-expanded="false" aria-controls="collapsePending">
                        <div class="sb-nav-link-icon"><i class="bi bi-hourglass-split"></i></div>
                        Pending
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePending" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <div class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="/admin/pending">All Data</a>
                        </div>
                    </div>
                <?php endif ?>

                <div class="sb-sidenav-menu-heading">Setting</div>

                <?php if (in_groups('SuperAdmin') || in_groups('Admin')) :; ?>
                    <a class="nav-link" href="/user/manajemen">
                        <div class="sb-nav-link-icon"><i class="bi bi-person-lines-fill"></i></div>
                        User Management
                    </a>
                <?php endif ?>

                <a class="nav-link" href="/user/list">
                    <div class="sb-nav-link-icon"><i class="bi bi-person-lines-fill"></i></div>
                    User List
                </a>

                <?php if (in_groups('SuperAdmin') || in_groups('Admin')) :; ?>
                    <a class="nav-link" href="/admin/setting">
                        <div class="sb-nav-link-icon"><i class="bi bi-sliders"></i></div>
                        Map View
                    </a>
                <?php endif ?>

                <a class="nav-link" href="/contact">
                    <div class="sb-nav-link-icon"><i class="bi bi-envelope-fill"></i></div>
                    Contact
                </a>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <span><?= user()->username; ?></span>
        </div>
    </nav>
</div>