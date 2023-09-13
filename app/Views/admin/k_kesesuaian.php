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
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css " rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/css/StyleAdmin.css" rel="stylesheet" />

    <style>
        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 0.3px solid #d5d5d5;
        }

        .dataTables_filter {
            margin-bottom: 1rem;
        }

        .paginate_button.disabled,
        .paginate_button.disabled:hover,
        .paginate_button.disabled:active {
            cursor: default;
            color: #666 !important;
            border: 1px solid transparent !important;
            background: transparent !important;
            box-shadow: none;
        }

        .paginate_button {
            border: 1px solid rgb(52, 93, 167) !important;
        }

        .paginate_button:hover,
        .paginate_button:active {
            background-color: rgb(52, 93, 167) !important;
            background: rgb(52, 93, 167) !important;
        }

        /* #hasilKesesuaian {
            overflow-x: auto;
        } */
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
                    <h1 class="mt-2 mb-3">Data Kesesuaian</h1>

                    <div class="card mb-4">
                        <div class="card-body">

                            <!-- <a href="/admin/kegiatan/tambah" class="btn btn-primary m-1 mb-4 bi bi-plus" role="button">Tambah</a> -->

                            <div class="table-content overflow-auto">
                                <table id="datatablesSimple" class="table table-striped row-border hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Zona</th>
                                            <th>Sub Zona</th>
                                            <th>Kode Kegiatan</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Status Kesesuaian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1 ?>
                                        <?php
                                        $prevKodeKegiatan = null; // Inisialisasi kode_kegiatan sebelumnya
                                        $prevIdZona = null; // Inisialisasi id_zona sebelumnya
                                        $prevSubZona = null; // Inisialisasi sub_zona sebelumnya
                                        ?>
                                        <?php foreach ($dataKesesuaian as $K) : ?>
                                            <?php
                                            $bold = '';
                                            if ($prevKodeKegiatan === $K->kode_kegiatan && $prevIdZona === $K->id_zona && $prevSubZona === $K->sub_zona) {
                                                $bold = 'font-weight:bold; background-color:red;';
                                            }
                                            ?>
                                            <tr style="<?= $bold ?>">
                                                <td><?= $i++; ?></td>
                                                <td><?= $K->nama_zona; ?></td>
                                                <td><?= $K->sub_zona ?? "-"; ?></td>
                                                <td><?= $K->kode_kegiatan; ?></td>
                                                <td><?= $K->nama_kegiatan; ?></td>
                                                <td style="color: <?= ($K->status == "diperbolehkan") ? 'green' : (($K->status == "diperbolehkan bersyarat") ? 'brown' : 'red'); ?>;"><?= $K->status; ?></td>
                                                <td>
                                                    <div class="d-inline-flex gap-1">
                                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                                            <a href="/admin/kegiatan/edit/<?= $K->id_zona; ?>" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
                                                        </div>
                                                        <!-- <div class="btn-group mr-2" role="group" aria-label="First group">
                                                            <form action="/admin/delete_kegiatan/<?= $K->id_zona; ?>" method="post">
                                                                <?= csrf_field(); ?>
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button type="submit" class="asbn btn btn-danger bi bi-trash" onclick="return confirm('Yakin Hapus Data?')"></button>
                                                            </form>
                                                        </div> -->
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            $prevKodeKegiatan = $K->kode_kegiatan; // Simpan kode_kegiatan saat ini
                                            $prevIdZona = $K->id_zona; // Simpan id_zona saat ini
                                            $prevSubZona = $K->sub_zona; // Simpan sub_zona saat ini
                                            ?>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>

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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/816b3ace5c.js" crossorigin="anonymous"></script>
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>

    <script>
        new DataTable('#datatablesSimple');
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



</body>

</html>