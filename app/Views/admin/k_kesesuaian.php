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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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

        .select2-dropdown,
        .select2-search {
            z-index: 2000;
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


                <!-- MODAL EDIT/UPDATE -->
                <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditLabel">Edit</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="tempatEdit">
                                    <input type="hidden" id="id_kesesuaian" value="">
                                    <input type="hidden" id="id_znkwsn" value="">
                                    <div class="mb-3">
                                        <label for="editZona" class="form-label">Zona</label>
                                        <select class="form-select select2" name="editZona" id="editZona" style="width: 100%;" required>
                                            <option></option>
                                            <?php foreach ($dataZona as $Z) : ?>
                                                <option value="<?= $Z->id_zona; ?>"><?= $Z->nama_zona; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editKawasan" class="form-label">Kawasan</label>
                                        <input class="form-control form-control-sm" type="text" placeholder="kode kawasan" aria-label=".form-control-sm" name="editKawasan" id="editKawasan" value="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editKegiatan" class="form-label">Jenis Kegiatan</label>
                                        <select class="form-select select2" name="editKegiatan" id="editKegiatan" style="width: 100%;" required>
                                            <option> </option>
                                            <?php foreach ($dataKegiatan as $kg) : ?>
                                                <option value="<?= $kg->kode_kegiatan; ?>"><?= $kg->id_kegiatan; ?>. <?= $kg->nama_kegiatan; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editStatus" class="form-label">Statu Kesesuaian</label>
                                        <?php $status_enum = ['diperbolehkan', 'diperbolehkan bersyarat', 'tidak diperbolehkan'] ?>
                                        <select class="form-select form-select-sm" name="editStatus" id="editStatus" required>
                                            <?php foreach ($status_enum as $S) : ?>
                                                <option value="<?= $S; ?>"><?= $S; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <p class="form-text d-none notempty" style="color: red;"><i>Pola Ruang, Kawasan, Kegiatan</i> Tidak Boleh Kosong</p>
                                    <button type="button" role="button" class="btn btn-primary" id="updatekan">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="container-fluid px-4">
                    <h1 class="mt-2 mb-3">Data Kesesuaian</h1>

                    <div class="card mb-4">
                        <div class="card-body">

                            <div class="row mb-2">
                                <div class="col-md-6 mb-2">
                                    <label class="col-md-12 mb-2">Filter Berdasarkan: <span style="color: red;"></label>
                                    <select class="form-select" id="pilihZona" name="zona" style="width: 100%;">
                                        <option></option>
                                        <?php $firstZona = reset($dataZona); ?>
                                        <?php foreach ($dataZona as $Z) : ?>
                                            <option value=" <?= $Z->id_zona ?>"><?= $Z->nama_zona ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>


                            <div class="table-content overflow-auto" id="table-content-byZona">
                                <h6 class="pt-2 pb-2">Zona: semua zona</h6>
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
                                                            <form action="/admin/" method="post">
                                                                <button type="button" class="asbn btn btn-primary bi bi-pencil-square" data-bs-toggle="modal" data-bs-target="#modalEdit" onclick="editkan(<?= $K->id_kesesuaian; ?>)"></button>
                                                            </form>
                                                        </div>
                                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                                            <form action="/admin/" method="post">
                                                                <button type="button" class="asbn btn btn-danger bi bi-trash"></button>
                                                            </form>
                                                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/scripts.js"></script>

    <script>
        new DataTable('#datatablesSimple');
    </script>
    <script>
        function editkan(id_kesesuaian, kode_kawasan) {
            console.log(id_kesesuaian);
            console.log(kode_kawasan);
            $.ajax({
                type: "method",
                url: `/admin/dataKesesuaian/${id_kesesuaian}/${kode_kawasan}`,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                }
            });
        }
    </script>
    <script>
        $("#pilihZona").change(function(e) {
            e.preventDefault();
            let zona = $("#pilihZona").val();
            console.log(zona);
            $.ajax({
                type: "POST",
                url: `/admin/kesesuaianByZona/${zona}`,
                data: zona,
                dataType: "html",
            }).done(function(response) {
                $("#table-content-byZona").html(response);
            }).fail(function(error) {
                console.error('Error:', error);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#editKegiatan").select2({
                placeholder: "Pilih Kegiatan",
                allowClear: true
            });
        });
        $(document).ready(function() {
            $("#editZona").select2({
                placeholder: "Pilih Zona",
                allowClear: true
            });
        });
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