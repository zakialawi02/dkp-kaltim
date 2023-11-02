<?php
$allData = $allDataPermohonan;
$allDataBaru = [];
$allDataSetujui = [];
$allDataTolak = [];
foreach ($allData as $key => $row) {
    if ($row->stat_appv == 0) {
        $allDataBaru[] = $row;
    } elseif ($row->stat_appv == 1) {
        $allDataSetujui[] = $row;
    } elseif ($row->stat_appv == 2) {
        $allDataTolak[] = $row;
    }
}
$allDataTerjawab = array_merge($allDataSetujui, $allDataTolak);
usort($allDataSetujui, function ($a, $b) {
    return strtotime($b->date_updated) - strtotime($a->date_updated);
});
usort($allDataTolak, function ($a, $b) {
    return strtotime($b->date_updated) - strtotime($a->date_updated);
});
usort($allDataTerjawab, function ($a, $b) {
    return strtotime($b->date_updated) - strtotime($a->date_updated);
});
$countAllPermohonan = count($allData);
// $countAllSetujui = count($allDataSetujui);
$countAllPending = count($allDataBaru);
// $countAllTolak = count($allDataTolak);
$allDataTerjawab = array_slice($allDataTerjawab, 0, 5);
$allDataBaru = array_slice($allDataBaru, 0, 5);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="Simata Laut, Sistem Informasi Tata Ruang Laut, Dinas Kelautan dan Perikanan" name="keywords">
    <meta content="Aplikasi Simata Laut Kaltim (Sistem Informasi Tata Ruang Laut Kaltim) Dinas Kelautan dan Perikanan Provinsi Kalimantan Timur." name="description">

    <title><?= $title; ?></title>
    <!-- Favicons -->
    <link href="/img/favicon.png" rel="icon">

    <!-- vendor css -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css " rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/css/StyleAdmin.css" rel="stylesheet" />

    <style>
        .map {
            position: relative;
            height: 50vh;
        }

        .name {
            min-width: 11em;
            word-wrap: break-word;
        }

        .address {
            min-width: 14em;
            word-wrap: break-word;
        }
    </style>

</head>

<body class="sb-nav-fixed">
    <!-- NAV HAEADER -->
    <?= $this->include('_Layout/_template/_admin/header'); ?>
    <div id="layoutSidenav">
        <!-- SIDEBAR -->
        <?= $this->include('_Layout/_template/_admin/sidebar'); ?>

        <div id="layoutSidenav_content">

            <!-- MAIN CONTENT -->
            <main>
                <div class="container-fluid px-4">

                    <div class="pagetitle">
                        <h1><?= $title; ?></h1>
                    </div>

                    <div class="dashboard">

                        <div class="row">

                            <!-- Left side columns -->
                            <div class="col-lg-8">
                                <div class="row">

                                    <!--  Card -->
                                    <div class="col-xxl-4 col-md-6 mb-3">
                                        <div class="card info-card totalls-card h-100">

                                            <div class="card-body">
                                                <h5 class="card-title">Total Permohonan Informasi</h5>

                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-file-earmark-text"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6><?= $countAllPermohonan; ?></h6>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div><!-- End  Card -->

                                    <!-- Incrase Card -->
                                    <div class="col-xxl-4 col-md-6 mb-3">
                                        <div class="card info-card pending-card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">Menunggu Tindakan</h5>

                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-hourglass-top"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6><?= $countAllPending; ?></h6>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div><!-- End Incrase Card -->

                                    <!-- user Card -->
                                    <div class="col-xxl-4 col-xl-12 mb-3">
                                        <div class="card info-card users-card h-100">

                                            <div class="card-body">
                                                <h5 class="card-title">Total Pengguna</h5>

                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-people"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6><?= $countAllUser; ?></h6>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div><!-- End user Card -->

                                    <!-- Daftar Data Masuk -->
                                    <div class="col-12 p-2 pr-2 mb-3">
                                        <div class="card recent-sales overflow-auto p-2">
                                            <div class="card-body">
                                                <h5 class="card-title">Daftar Permohonan Baru | 5 Terbaru</h5>

                                                <table id="tabels" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Tanggal Masuk</th>
                                                            <th>NIK</th>
                                                            <th class="name">Nama Pemohon</th>
                                                            <th class="address">Nama Kegiatan</th>
                                                            <th>Kontak</th>
                                                            <th> </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($allDataBaru as $baru) : ?>
                                                            <tr>
                                                                <td><?= date('d M Y', strtotime($baru->created_at)); ?></td>
                                                                <td><?= esc($baru->nik); ?></td>
                                                                <td><?= esc($baru->nama); ?></td>
                                                                <td><?= esc($baru->nama_kegiatan); ?></td>
                                                                <td><?= esc($baru->kontak); ?></td>
                                                                <td><a type="button" role="button" href="/admin/data/permohonan/<?= ($baru->stat_appv == '0') ? 'menunggu-jawaban' : ''; ?>/lihat/<?= $baru->id_perizinan; ?>" class="asbn btn btn-info bi bi-binoculars" data-bs-toggle="tooltip" data-bs-placement="top" title="Periksa" target="_blank"></a></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>

                                                <a type="button" class="btn btn-primary" href="/admin/data/permohonan/masuk">Lihat Lebih Banyak</a>
                                            </div>

                                        </div>
                                    </div><!-- End Daftar -->

                                    <!-- Daftar Pemohon -->
                                    <div class="col-12 p-2 pr-2 mb-3">
                                        <div class="card recent-sales overflow-auto p-2">
                                            <div class="card-body">
                                                <h5 class="card-title">Daftar Permohonan Dijawab | 5 Terbaru</h5>

                                                <table id="tabels" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Tanggal Jawaban</th>
                                                            <th>NIK</th>
                                                            <th class="name">Nama Pemohon</th>
                                                            <th class="address">Nama Kegiatan</th>
                                                            <th>Status</th>
                                                            <th> </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($allDataTerjawab as $jawab) : ?>
                                                            <tr>
                                                                <td><?= date('d M Y', strtotime($jawab->date_updated)); ?></td>
                                                                <td><?= esc($jawab->nik); ?></td>
                                                                <td class="name"><?= esc($jawab->nama); ?></td>
                                                                <td class="address"><?= esc($jawab->nama_kegiatan); ?></td>
                                                                <td><span class="badge bg-<?= ($jawab->stat_appv == '1') ? 'success' : 'danger'; ?>"> <?= ($jawab->stat_appv == '1') ? 'Disetujui' : 'Tidak Disetujui'; ?> </span></td>
                                                                <td><a type="button" role="button" href="/admin/data/permohonan/<?= ($jawab->stat_appv == '1') ? 'telah-disetujui' : 'tidak-disetujui'; ?>/lihat/<?= $jawab->id_perizinan; ?>" class="asbn btn btn-secondary bi bi-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat" target="_blank"></a></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>

                                                <a type="button" class="btn btn-primary" href="/admin/data/permohonan/disetujui/semua">Lihat Lebih Banyak</a>
                                            </div>

                                        </div>
                                    </div><!-- End Daftar pemohon -->

                                </div>

                            </div><!-- End Left side columns -->

                            <!-- Right side columns -->
                            <div class="col-lg-4">

                                <!-- New users -->
                                <div class="card">

                                    <div class="card-body mb-3">
                                        <h5 class="card-title">Pengguna Baru <span>| 30 Hari Terakhir</span></h5>

                                        <div class="activity">

                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Username</th>
                                                        <th scope="col">Tanggal Daftar</th>
                                                        <th scope="col">Role</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($userMonth as $newUs) : ?>
                                                        <tr>
                                                            <td><?= esc($newUs->username); ?></td>
                                                            <td> <?= date('d M Y', strtotime($newUs->created_at)); ?></td>
                                                            <td><span class="badge bg-<?= ($newUs->name == 'Admin' or $newUs->name == 'SuperAdmin') ? 'info' : 'secondary'; ?>"> <?= $newUs->name; ?> </span></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                            <center>
                                                <p><?= ($userMonth == null) ? 'Tidak ada Data' : null; ?> </p>
                                            </center>

                                        </div>
                                        <a type="button" class="btn btn-primary" href="/user/kelola">Lihat Lebih Banyak</a>

                                    </div>

                                </div>


                            </div><!-- End user Activity -->

                        </div>

                    </div>

                </div>
            </main>

            <!-- FOOTER -->
            <?= $this->include('_Layout/_template/_admin/footer'); ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="/js/datatables-simple-demo.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>
    <script src="/js/scripts.js"></script>
    <script>
        $(document).ready(function() {
            $("th").css("pointer-events", "none");
            $(".no-sort").css("pointer-events", "none");
        });
    </script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
    <?php if (session()->getFlashdata('success')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?= session()->getFlashdata('success'); ?>',
                timer: 1500,
            });
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session()->getFlashdata('error'); ?>',
                timer: 1500,
            });
        </script>
    <?php endif; ?>

    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var userId = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin ingin menghapus data ini?',
                    text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus data!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form-' + userId).submit();
                    }
                });
            });
        });
    </script>

</body>

</html>