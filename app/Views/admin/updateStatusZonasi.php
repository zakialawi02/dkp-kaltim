<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title><?= $title; ?></title>
    <!-- Favicons -->
    <link href="/img/favicon.png" rel="icon">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css " rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="/css/StyleAdmin.css" rel="stylesheet" />


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
                    <h1 class="mt-2 mb-3">Data Status Zonasi</h1>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Edit Data</h4>

                            <form action="/admin/updateStatusZonasi/<?= $dataZonasi[0]->id_kegiatan; ?>" method="post" id="formUpdateStatusZonasi">
                                <div class="mb-3">
                                    <label for="nama_kegiatan" class="form-label">Nama Jenis Kegiatan</label>
                                    <select class="form-select" id="pilihKegiatan" name="kegiatan" for="kegiatan" style="width: 100%;" required>
                                        <option></option>
                                        <?php foreach ($jenisKegiatan as $K) : ?>
                                            <option value="<?= $K->id_kegiatan ?>" <?= $K->id_kegiatan == $dataZonasi[0]->id_kegiatan ? 'selected' : '' ?>><?= $K->nama_kegiatan ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="col-md-6"></div>
                                <div class="row g-2">
                                    <?php foreach ($dataZonasi as $data) : ?>
                                        <div class="col-md-6 mb-3">
                                            <label for="select<?= $data->id_sub; ?>" class="form-label"><?= $data->nama_subzona; ?></label>
                                            <select class="form-select" name="statusZonasi[]" id="select<?= $data->id_sub; ?>" aria-label="Default">
                                                <option value="1" <?php echo ($data->status_zonasi == '1') ? 'selected' : ''; ?>>I</option>
                                                <option value="2" <?php echo ($data->status_zonasi == '2') ? 'selected' : ''; ?>>T</option>
                                                <option value="3" <?php echo ($data->status_zonasi == '3') ? 'selected' : ''; ?>>X</option>
                                            </select>
                                        </div>
                                    <?php endforeach ?>

                                </div>

                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </form>

                        </div>
                    </div>

                </div>
            </main><!-- End #main -->

            <!-- FOOTER -->
            <?= $this->include('_Layout/_template/_admin/footer'); ?>

        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#pilihKegiatan').select2({
                placeholder: "Pilih Jenis Kegiatan",
                allowClear: true
            });
            $('#SubZona').select2({
                placeholder: "Pilih Zona Wilayah Kegiatan",
                allowClear: true
            });
        });
    </script>
    <script>
        $('#pilihKegiatan').change(function(e) {
            e.preventDefault();
            var kegiatanId = $('#pilihKegiatan').val();
            var redirectUrl = '<?php echo base_url("admin/data/zonasi"); ?>/' + kegiatanId + '/edit/';
            window.location.href = redirectUrl;
        });
    </script>

</body>

</html>