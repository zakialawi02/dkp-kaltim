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
                <div class="modal fade" id="modalEdit" aria-labelledby="modalEditLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditLabel">Edit</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="load-data text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                                <div class="tempatEdit">
                                    <form id="editForm" method="post">
                                        <?php csrf_field() ?>
                                        <input type="hidden" id="id_kesesuaian" value="">
                                        <div class="mb-3">
                                            <label for="editZona" class="form-label">Zona</label>
                                            <select class="form-select select2" name="editZona" id="editZona" style="width: 100%;" required>
                                                <option></option>
                                                <?php foreach ($dataZona as $Z) : ?>
                                                    <option value="<?= $Z->id_zona; ?>"><?= esc($Z->nama_zona); ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="mb-3 editSubZona">
                                            <label for="editSubZona" class="form-label">Sub Zona</label>
                                            <select class="form-select form-select-sm" name="editSubZona" id="editSubZona" style="width: 100%;">
                                                <option value="Inti">Zona Inti</option>
                                                <option value="ZPT">Zona Pemanfaatan Terbatas</option>
                                                <option value="Lainnya">Zona Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editKegiatan" class="form-label">Jenis Kegiatan</label>
                                            <select class="form-select select2" name="editKegiatan" id="editKegiatan" style="width: 100%;" required>
                                                <option> </option>
                                                <?php foreach ($dataKegiatan as $kg) : ?>
                                                    <option value="<?= $kg->kode_kegiatan; ?>"><?= esc($kg->kode_kegiatan); ?> - <?= esc($kg->nama_kegiatan); ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="editStatus" class="form-label">Status Kesesuaian</label>
                                            <?php $status_enum = ['diperbolehkan', 'diperbolehkan bersyarat', 'tidak diperbolehkan'] ?>
                                            <select class="form-select form-select-sm" name="editStatus" id="editStatus" required>
                                                <?php foreach ($status_enum as $S) : ?>
                                                    <option value="<?= $S; ?>"><?= $S; ?></option>
                                                <?php endforeach ?>
                                            </select>
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




                <div class="container-fluid px-4">
                    <h1 class="mt-2 mb-3">Data Kesesuaian</h1>

                    <div class="card mb-4">
                        <div class="card-body">

                            <form id="tambahForm" method="post">
                                <?php csrf_field() ?>
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label for="tambahZona" class="form-label">Zona</label>
                                                        <select class="form-select select2" name="tambahZona" id="tambahZona" style="width: 100%;" required>
                                                            <option></option>
                                                            <?php foreach ($dataZona as $Z) : ?>
                                                                <option value="<?= $Z->id_zona; ?>"><?= esc($Z->nama_zona); ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 tambahSubZona d-none">
                                                    <div class="mb-3">
                                                        <label for="tambahSubZona" class="form-label">Sub Zona</label>
                                                        <select class="form-select form-select-sm" name="tambahSubZona" id="tambahSubZona" style="width: 100%;">
                                                            <option value="Inti">Zona Inti</option>
                                                            <option value="ZPT">Zona Pemanfaatan Terbatas</option>
                                                            <option value="Lainnya">Zona Lainnya</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label for="tambahKegiatan" class="form-label">Jenis Kegiatan</label>
                                                        <select class="form-select select2" name="tambahKegiatan" id="tambahKegiatan" style="width: 100%;" required>
                                                            <option> </option>
                                                            <?php foreach ($dataKegiatan as $kg) : ?>
                                                                <option value="<?= $kg->kode_kegiatan; ?>"><?= esc($kg->kode_kegiatan); ?> - <?= esc($kg->nama_kegiatan); ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="tambahStatus" class="form-label">Status Kesesuaian</label>
                                                        <select class="form-select form-select-sm" name="tambahStatus" id="tambahStatus" required>
                                                            <option> </option>
                                                            <?php foreach ($status_enum as $S) : ?>
                                                                <option value="<?= $S; ?>"><?= $S; ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-text" id="textHelp" style="color: red;"></div>
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

                            <div class="row mb-2">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-2">Filter Berdasarkan:</label>
                                    <select class="form-select" id="pilihZona" name="pilihZona" style="width: 100%;">
                                        <option value="0">Semua Zona</option>
                                        <?php foreach ($dataZona as $Z) : ?>
                                            <option value="<?= $Z->id_zona ?>" <?= ($Z->id_zona == $zona) ? 'selected' : '' ?>><?= esc($Z->nama_zona) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>


                            <?php foreach ($dataZona as $Z) : ?>
                                <?php if ($Z->id_zona == $zona) : ?>
                                    <?php $nama_zona = $Z->nama_zona ?>
                                    <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <h6 class="pt-2 pb-2">Zona: <?= $nama_zona ?? 'Semua Zona' ?></h6>
                            <div class="table-content overflow-auto" id="table-content-byZona">
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
                                                $bold = 'font-weight:bold; background-color:orange;';
                                            }
                                            ?>
                                            <tr style="<?= $bold ?>">
                                                <td><?= $i++; ?></td>
                                                <td><?= esc($K->nama_zona); ?></td>
                                                <td><?= (empty($K->sub_zona)) ? "-" : esc($K->sub_zona); ?></td>
                                                <td><?= esc($K->kode_kegiatan); ?></td>
                                                <td><?= esc($K->nama_kegiatan); ?></td>
                                                <td style="color: <?= ($K->status == "diperbolehkan") ? 'green' : (($K->status == "diperbolehkan bersyarat") ? 'brown' : 'red'); ?>;"><?= esc($K->status); ?></td>
                                                <td>
                                                    <div class="d-inline-flex gap-1">
                                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                                            <form action="/admin/" method="post">
                                                                <button type="button" class="asbn btn btn-primary bi bi-pencil-square" data-bs-toggle="modal" data-bs-target="#modalEdit" onclick="editkan(<?= $K->id_kesesuaian; ?>)"></button>
                                                            </form>
                                                        </div>
                                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                                            <form action="/admin/" method="post">
                                                                <button type="button" class="asbn btn btn-danger bi bi-trash" onclick="hapuskan(<?= $K->id_kesesuaian; ?>)"></button>
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
        $("#pilihZona").change(function(e) {
            loadTabelKesesuaian()
        });

        function loadTabelKesesuaian() {
            const zona = $("#pilihZona").val();
            history.replaceState(null, "", `/admin/kesesuaian?zona=${zona}`)
            $.ajax({
                type: "GET",
                url: `/admin/kesesuaianByZona?zona=${zona}`,
                dataType: "html",
            }).done(function(response) {
                $("h6[class='pt-2 pb-2']").text("Zona: " + $("#pilihZona").find(":selected").text());
                $("#table-content-byZona").html(response);
            }).fail(function(error) {
                console.error('Error:', error);
            });
        }
        $("#pilihZona").select2({
            placeholder: "Pilih Kegiatan",
            allowClear: true
        });
        $("#tambahZona").select2({
            placeholder: "Pilih Zona",
            allowClear: true
        });
        $("#tambahKegiatan").select2({
            placeholder: "Pilih Kegiatan",
            allowClear: true
        });
        $("#editKegiatan").select2({
            placeholder: "Pilih Kegiatan",
            dropdownParent: $("#modalEdit"),
            allowClear: true
        });
        $("#editZona").select2({
            placeholder: "Pilih Zona",
            dropdownParent: $("#modalEdit"),
            allowClear: true
        });
        let subzona;
        let strictZone = ["Kawasan Konservasi Lainnya", "Taman", "Kawasan Konservasi Maritim", "Pencadangan/Indikasi Kawasan Konservasi"];
        $("#tambahZona").change(function() {
            let valueZona = $("#tambahZona").find(":selected").text();
            if (strictZone.includes(valueZona)) {
                $(".tambahSubZona").removeClass("d-none");
                $("#tambahSubZona").prop("required", true);
                subzona = true;
            } else {
                $(".tambahSubZona").addClass("d-none");
                $("#tambahSubZona").prop("required", false);
                subzona = false;
            }
        });
        $("#editZona").change(function() {
            let valueZona = $("#editZona").find(":selected").text();
            if (strictZone.includes(valueZona)) {
                $(".editSubZona").removeClass("d-none");
                $("#editSubZona").prop("required", true);
                subzona = true;
            } else {
                $(".editSubZona").addClass("d-none");
                $("#editSubZona").prop("required", false);
                subzona = false;
            }
        });

        $("#tambahkan").click(function(e) {
            e.preventDefault();
            $("#tambahForm #textHelp").html("");
            let tambahZona = $("#tambahZona").val();
            let tambahSubZona = null;
            if (subzona) {
                tambahSubZona = $("#tambahSubZona").val();
            }
            let tambahKegiatan = $("#tambahKegiatan").val();
            let tambahStatus = $("#tambahStatus").val();
            let isValid = true;
            $("#tambahForm select[required]").each(function() {
                if ($(this).val() == "" || $(this).val() == null) {
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
                url: `/admin/tambahAturanKesesuaian`,
                data: {
                    tambahZona,
                    tambahSubZona,
                    tambahKegiatan,
                    tambahStatus
                },
                dataType: "html",
            }).done(function(response) {
                loadTabelKesesuaian();
                ToastSuccess.fire({
                    icon: 'success',
                    title: 'Berhasil Menambahkan Data'
                })
            }).fail(function(error) {
                console.error('Error:', error);
                ToastSuccess.fire({
                    icon: 'error',
                    title: 'Gagal Menambahkan Data'
                })
            });
        });
        $("#updatekan").click(function(e) {
            $("#editForm #textHelp").html("");
            e.preventDefault();
            let editZona = $("#editZona").val();
            let editSubZona = null;
            if (subzona) {
                editSubZona = $("#editSubZona").val();
            }
            let editKegiatan = $("#editKegiatan").val();
            let editStatus = $("#editStatus").val();
            let isValid = true;
            $("#editForm select[required]").each(function() {
                if ($(this).val() == "" || $(this).val() == null) {
                    isValid = false;
                    return false;
                }
            });
            if (!isValid) {
                $("#editForm  #textHelp").html("Harap isi semua kolom yang ada");
                return;
            }
            const url = $("#editForm").attr("action");
            $.ajax({
                method: "POST",
                url: url,
                data: {
                    editZona,
                    editSubZona,
                    editKegiatan,
                    editStatus
                },
                dataType: "html",
            }).done(function(response) {
                ToastSuccess.fire({
                    icon: 'success',
                    title: 'Berhasil Memperbarui Data'
                })
                $("#modalEdit").modal("hide");
                $(".modal-backdrop").modal("hide");
                loadTabelKesesuaian();
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

        function editkan(id_kesesuaian) {
            $(".load-data").removeClass("d-none");
            $(".tempatEdit").addClass("d-none");
            $.ajax({
                method: "GET",
                url: `/admin/dataKesesuaian/${id_kesesuaian}`,
                dataType: "json",
            }).done(function(response) {
                $(".load-data").addClass("d-none");
                $(".tempatEdit").removeClass("d-none");
                let data = response[0];
                const url = `/admin/updateAturanKesesuaian/${data.id_kesesuaian}`
                $("#editForm").attr("action", url);
                $("#editZona").val(data.id_zona).trigger('change');
                $("#editSubZona").val(data.sub_zona);
                $("#editKegiatan").val(data.kode_kegiatan).trigger('change');
                $("#editStatus").val(data.status);
            }).fail(function(error) {
                console.error('Error:', error);
            });
        }

        function hapuskan(id_kesesuaian) {
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
                        url: `/admin/delete_kesesuaian/${id_kesesuaian}`,
                        data: {
                            _method: "DELETE",
                            <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                        },
                        dataType: "html",
                    }).done(function(response) {
                        loadTabelKesesuaian();
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