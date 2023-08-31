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
                                    <label for="editRuang" class="form-label">Pemanfaatan Pola Ruang</label>
                                    <select class="form-select form-select-sm" name="editRuang" id="editRuang" required>
                                        <option></option>
                                        <?php foreach ($dataRencanaRuang as $R) : ?>
                                            <option value="<?= $R->id_rencana; ?>"><?= $R->nama_rencana_pemanfaatan; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editZona" class="form-label">Zona Khusus</label>
                                    <select class="form-select form-select-sm" name="editZona" id="editZona" required>
                                        <option value="" selected>tidak ada</option>
                                        <?php foreach ($dataZonaType as $Z) : ?>
                                            <option value="<?= $Z->id_zona; ?>"><?= $Z->nama_zona; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editKawasan" class="form-label">Kawasan</label>
                                    <input class="form-control form-control-sm" type="text" placeholder="kode kawasan" aria-label=".form-control-sm" name="editKawasan" id="editKawasan" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editKegiatan" class="form-label">Kegiatan</label>
                                    <select class="form-select form-select-sm select2" name="editKegiatan" id="editKegiatan" style="width: 100%;" required>
                                        <option></option>
                                        <?php foreach ($dataKegiatan as $kg) : ?>
                                            <option value="<?= $kg->kode_kegiatan; ?>"><?= $kg->id_kegiatan; ?>. <?= $kg->nama_kegiatan; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editStatus" class="form-label">Kawasan</label>
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

            <!-- MAIN CONTENT -->
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-2 mb-3">Data Status Kesesuaian</h1>

                    <div class="card mb-4">
                        <div class="card-body">


                            <!-- <a href="/admin/kegiatan/tambah" class="btn btn-primary m-1 mb-4 bi bi-plus" role="button">Tambah</a> -->
                            <div class="hasilKesesuaian overflow-auto" id="hasilKesesuaian">
                                <table id="datatablesSimple" class="table table-striped row-border hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Pola Ruang</th>
                                            <th>Zona Khusus</th>
                                            <th>Kawasan</th>
                                            <th>Kegiatan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1 ?>
                                        <?php foreach ($dataKesesuaian as $K) : ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td>(<?= $K->id_rencana_objek; ?>) <?= $K->nama_rencana_pemanfaatan; ?></td>
                                                <td>(<?= $K->id_zona; ?>) <?= ($K->nama_zona != null) ? $K->nama_zona : '-'; ?></td>
                                                <td><?= $K->kode_kawasan; ?></td>
                                                <td>(<?= $K->kode_kegiatan; ?>) <?= $K->nama_kegiatan; ?></td>
                                                <td><?= $K->status_k; ?></td>

                                                <td>
                                                    <div class="d-inline-flex gap-1">
                                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                                            <form action="/admin/" method="post">
                                                                <button type="button" class="asbn btn btn-primary bi bi-pencil-square"></button>
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

    <script>
        new DataTable('#datatablesSimple');
    </script>

    <script>
        const ToastSuccess = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    </script>
    <script>
        $(document).ready(function() {
            $("#pilihKegiatan").select2({
                placeholder: "Pilih Jenis Kegiatan",
                allowClear: true
            });
        });
    </script>
    <script>
        function hapuskan(id) { //id=id punya tbl_kesesuaian
            Swal.fire({
                title: 'Anda Ingin Menhapus Data Ini?',
                text: "Data yang dihapus tidak bisa dikembalikan lagi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: `/admin/delete_kesesuaian/${id}`,
                        data: {
                            _method: "DELETE",
                            <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                        },
                        dataType: "html",
                    }).done(function(response) {
                        ToastSuccess.fire({
                            icon: 'success',
                            title: 'Berhasil Menghapus Data'
                        })
                        $("#hasilKesesuaian").html(response);
                    }).fail(function(error) {
                        console.error('Error:', error);
                        ToastSuccess.fire({
                            icon: 'error',
                            title: 'Gagal Menghapus Data'
                        })
                    });
                }
            })
        }
    </script>

</body>

</html>