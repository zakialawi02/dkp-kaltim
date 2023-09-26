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
                    <h1 class="mt-2 mb-3">Data Jenis Kegiatan</h1>


                    <!-- MODAL EDIT/UPDATE -->
                    <div class="modal fade" id="modalEdit" aria-labelledby="modalEditLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditLabel">Edit</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="tempatEdit">
                                        <form id="editForm" method="post">
                                            <?php csrf_field() ?>

                                            <input type="hidden" id="oldCode" name="oldCode">
                                            <div class="mb-3">
                                                <label for="editKegiatan" class="form-label">Nama Kegiatan</label>
                                                <input type="text" class="form-control form-control-sm" id="editKegiatan" name="editKegiatan" placeholder="Nama Kegiatan" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editKKegiatan" class="form-label">Kode Kegiatan</label>
                                                <input type="text" class="form-control form-control-sm" id="editKKegiatan" name="editKKegiatan" placeholder="K1" required>
                                            </div>
                                            <div class="form-text" id="textHelp" style="color: red;"></div>
                                            <div class="p-1 text-end">
                                                <button type="button" role="button" class="btn btn-primary" id="updatekan">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>




                    <div class="card mb-4">
                        <div class="card-body">

                            <form id="tambahForm" method="post">
                                <?php csrf_field() ?>
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="tambahKegiatan" class="form-label">Nama Kegiatan</label>
                                                        <input type="text" class="form-control form-control-sm" id="tambahKegiatan" name="tambahKegiatan" placeholder="Nama Kegiatan" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="tambahKKegiatan" class="form-label">Kode Kegiatan</label>
                                                        <input type="text" class="form-control form-control-sm" id="tambahKKegiatan" name="tambahKKegiatan" placeholder="K1" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-text" id="textHelp" style="color: red;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 align-self-center">
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary" id="tambahkan">Tambahkan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="card mb-4">
                        <div class="card-body">

                            <!-- <a href="/admin/kegiatan/tambah" class="btn btn-primary m-1 mb-4 bi bi-plus" role="button">Tambah</a> -->

                            <div class="table-content overflow-auto" id="table-content-byZona">
                                <table id="datatablesSimple" class="table table-striped row-border hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode Kegiatan</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1 ?>
                                        <?php foreach ($dataKegiatan as $K) : ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= esc($K->kode_kegiatan); ?></td>
                                                <td><?= esc($K->nama_kegiatan); ?></td>
                                                <td>
                                                    <div class="d-inline-flex gap-1">
                                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                                            <form action="/admin/" method="post">
                                                                <button type="button" class="asbn btn btn-primary bi bi-pencil-square" data-bs-toggle="modal" data-bs-target="#modalEdit" onclick="editkan(<?= $K->id_kegiatan; ?>)"></button>
                                                            </form>
                                                        </div>
                                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                                            <form action="/admin/" method="post">
                                                                <button type="button" class="asbn btn btn-danger bi bi-trash" onclick="hapuskan(<?= $K->id_kegiatan; ?>)"></button>
                                                            </form>
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
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>
    <script src="/js/scripts.js"></script>

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
        function loadTabelKegiatan() {
            $.ajax({
                type: "GET",
                url: `/admin/loadKegiatan`,
                dataType: "html",
            }).done(function(response) {
                $("#table-content-byZona").html(response);
            }).fail(function(error) {
                console.error('Error:', error);
            });
        }
        $("#tambahkan").click(function(e) {
            e.preventDefault();
            $("#tambahForm #textHelp").html("");
            let tambahKegiatan = $("#tambahKegiatan").val();
            let tambahKKegiatan = $("#tambahKKegiatan").val();
            tambahKKegiatan = tambahKKegiatan.toUpperCase().replace(/\s+/g, '');
            $("#tambahKKegiatan ").val(tambahKKegiatan);
            let isValid = true;
            $("#tambahForm input[required]").each(function() {
                if ($(this).val() == "") {
                    isValid = false;
                    return;
                }
            });
            if (!isValid) {
                $("#tambahForm #textHelp").html("Harap isi semua kolom yang ada");
                return;
            }
            $.ajax({
                method: "POST",
                url: `/admin/tambahKegiatan`,
                data: {
                    tambahKegiatan,
                    tambahKKegiatan,
                },
                dataType: "json",
            }).done(function(response) {
                const status = response.status;
                const message = response.message;
                loadTabelKegiatan();
                ToastSuccess.fire({
                    icon: status,
                    title: message,
                })
                if (status !== "error") {
                    $("#tambahKegiatan").val("");
                    $("#tambahKKegiatan").val("");
                }
            }).fail(function(error) {
                console.error('Error:', error);
                ToastSuccess.fire({
                    icon: 'error',
                    title: 'Gagal Menambahkan Data'
                })
            });
        });
        $("#updatekan").click(function(e) {
            e.preventDefault();
            $("#editForm #textHelp").html("");
            let oldCode = $("#oldCode").val();
            let editKegiatan = $("#editKegiatan").val();
            let editKKegiatan = $("#editKKegiatan").val();
            editKKegiatan = editKKegiatan.toUpperCase().replace(/\s+/g, '');
            $("#editKKegiatan ").val(editKKegiatan);
            let isValid = true;
            $("#editForm input[required]").each(function() {
                if ($(this).val() == "") {
                    isValid = false;
                    return;
                }
            });
            if (!isValid) {
                $("#editForm #textHelp").html("Harap isi semua kolom yang ada");
                return;
            }
            const url = $("#editForm").attr("action");
            $.ajax({
                method: "POST",
                url: url,
                data: {
                    oldCode,
                    editKegiatan,
                    editKKegiatan,
                },
                dataType: "json",
            }).done(function(response) {
                const status = response.status;
                const message = response.message;
                ToastSuccess.fire({
                    icon: status,
                    title: message,
                })
                if (status !== "error") {
                    $("#modalEdit").modal("hide");
                    $(".modal-backdrop").modal("hide");
                    loadTabelKegiatan();
                }
            }).fail(function(error) {
                console.error('Error:', error);
                ToastSuccess.fire({
                    icon: 'error',
                    title: 'Gagal Memperbarui Data'
                });
                $("#modalEdit").modal("hide");
                $(".modal-backdrop").modal("hide");
            });
        });

        function editkan(id_kegiatan) {
            $(".load-data").removeClass("d-none");
            $(".tempatEdit").addClass("d-none");
            $.ajax({
                method: "GET",
                url: `/admin/datakegiatan/${id_kegiatan}`,
                dataType: "json",
            }).done(function(response) {
                $(".load-data").addClass("d-none");
                $(".tempatEdit").removeClass("d-none");
                let data = response[0];
                const url = `/admin/updatekegiatan/${data.id_kegiatan}`
                $("#editForm").attr("action", url);
                $("#editKegiatan").val(data.nama_kegiatan);
                $("#oldCode").val(data.kode_kegiatan);
                $("#editKKegiatan").val(data.kode_kegiatan);
            }).fail(function(error) {
                console.error('Error:', error);
            });
        }

        function hapuskan(id_kegiatan) {
            Swal.fire({
                title: 'Anda Ingin Menghapus Data Ini?',
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
                        url: `/admin/delete_kegiatan/${id_kegiatan}`,
                        data: {
                            _method: "DELETE",
                            <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                        },
                        dataType: "html",
                    }).done(function(response) {
                        loadTabelKegiatan();
                        ToastSuccess.fire({
                            icon: 'success',
                            title: 'Berhasil Menghapus Data'
                        })
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