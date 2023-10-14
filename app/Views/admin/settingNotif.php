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
                    <h1 class="mt-2 mb-3"><?= $title; ?></h1>


                    <div class="card mb-4">
                        <div class="card-body">

                            <div class="card mb-3">
                                <div class="card-body m-0">
                                    <p class="mb-1">Data pemohon yang telah dibalas/dijawab akan mendapatkan notifikasi pemberitahuan status pengajuan informasi terkait.</p>
                                    <p class="mb-1">Anda dapat mematikan fitur notifikasi tersebut pada setting dibawah ini.</p>
                                </div>
                            </div>

                            <form action="/admin/UpdateSetting/pemberitahuan_ajuan" method="post" id="settingNotif" class="p-2 m-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notifEmail" name="notifEmail" <?= ($tampilData[0]->notif_email === "on") ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="notifEmail">Pemberitahuan Email</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notifWA" name="notifWA" <?= ($tampilData[0]->notif_wa === "on") ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="notifWA">Pemberitahuan Whatsapp</label>
                                </div>
                            </form>


                            <div class="card mb-3 <?= ($tampilData[0]->notif_wa === "on") ? '' : 'd-none'; ?>" id="expandNotifWA">
                                <div class="card-body m-0">
                                    <form action="/" method="post" id="settingNotifWA">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                                            <input class="form-control" type="text" placeholder="Default input">
                                        </div>
                                    </form>
                                </div>
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
        $("#settingNotif input[type='checkbox']").change(function(e) {
            var notifEmail = $("#notifEmail").is(':checked') ? 'on' : null;
            var notifWA = $("#notifWA").is(':checked') ? 'on' : null;
            $.post('/admin/UpdateSetting/pemberitahuan_ajuan', {
                notifEmail: notifEmail,
                notifWA: notifWA
            }, function(data) {
                ToastSuccess.fire({
                    icon: 'success',
                    title: 'Berhasil memperbarui pengaturan'
                })
            });
        });
        $("#notifWA").change(function(e) {
            $("#expandNotifWA").toggleClass('d-none');
        });
    </script>

</body>

</html>