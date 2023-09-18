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
                    <h1 class="mt-2 mb-3">Data Cakupan Kawasan</h1>

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
                                <table id="datatablesSimples" class="table table-striped row-border hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kawasan</th>
                                            <th>Zona</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1 ?>
                                        <?php foreach ($dataKawasan as $K) : ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $K->kode_kawasan; ?></td>
                                                <td><?= $K->nama_zona; ?></td>
                                                <td>
                                                    <div class="d-inline-flex gap-1">
                                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                                            <a href="/admin/zona/edit/<?= $K->id_znkwsn; ?>" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
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
    <script src="/js/scripts.js"></script>

    <script>
        new DataTable('#datatablesSimples');
    </script>
    <script>
        $(document).ready(function() {
            $("#pilihZona").select2({
                placeholder: "Pilih Berdasarkan Zona",
                allowClear: true
            });
        });
    </script>
    <script>
        $("#pilihZona").change(function(e) {
            e.preventDefault();
            let zona = $("#pilihZona").val();
            console.log(zona);
            $.ajax({
                type: "POST",
                url: `/admin/kawasanByZona/${zona}`,
                data: zona,
                dataType: "html",
            }).done(function(response) {
                $("#table-content-byZona").html(response);
            }).fail(function(error) {
                console.error('Error:', error);
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