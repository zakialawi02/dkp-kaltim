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

    <!-- vendor css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

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

                    <div class="pagetitle">
                        <h1><?= $title; ?></h1>
                    </div>

                    <section class="section">
                        <div class="row">

                            <div class="col-xl-4 p-3">
                                <div class="card">
                                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                        <img src="/img/user/<?= user()->user_image; ?>" alt="photo Profile" class="rounded-circle">
                                        <h2 class="m-1 mt-2 text-center"><?= user()->full_name; ?></h2>

                                        <?php if (in_groups('Admin' && 'SuperAdmin')) : ?>
                                            <a class="badge bg-secondary"><?= user()->username; ?></a>
                                        <?php else : ?>
                                            <a class="badge bg-info"><?= user()->username; ?></a>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-8 p-3">

                                <div class="card">
                                    <div class="card-body pt-3">
                                        <!-- Bordered Tabs -->
                                        <ul class="nav nav-tabs nav-tabs-bordered">

                                            <li class="nav-item">
                                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                                            </li>

                                            <li class="nav-item">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit-data">Edit Data</button>
                                            </li>

                                            <li class="nav-item">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ganti Password</button>
                                            </li>


                                        </ul>
                                        <div class="tab-content pt-3">

                                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                                <h5 class="card-title">About</h5>
                                                <p class="small fst-italic" id="user_about"><?= user()->user_about; ?></p>

                                                <h5 class="card-title">Profile Details</h5>

                                                <div class="mb-2 row">
                                                    <div class="col-lg-3 col-md-4 label ">Username</div>
                                                    <div class="col-lg-9 col-md-8">: <?= user()->username; ?></div>
                                                </div>

                                                <div class="mb-2 row">
                                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                                    <div class="col-lg-9 col-md-8" id="full_name">: <?= user()->full_name; ?></div>
                                                </div>

                                                <div class="mb-2 row">
                                                    <div class="col-lg-3 col-md-4 label ">Email</div>
                                                    <div class="col-lg-9 col-md-8">: <?= user()->email; ?></div>
                                                </div>

                                                <div class="mb-2 row">
                                                    <div class="col-lg-3 col-md-4 label ">Join at</div>
                                                    <div class="col-lg-9 col-md-8">: <?= date('d M Y', strtotime(user()->created_at)); ?></div>
                                                </div>

                                            </div>


                                            <div class="tab-pane fade pt-3" id="profile-edit-data">
                                                <!-- Change my Data -->
                                                <form action="/MyProfile/UpdateMyData/<?= user()->id; ?>" method="post" enctype="multipart/form-data" id="my-profile-form" autocomplete="off">



                                                    <div class="row mb-3 align-items-center ">
                                                        <label for="Foto Profil" class="col-md-4 col-lg-3 col-form-label">Foto Profil</label>
                                                        <input type="file" class="filepond" name="filepond" accept="image/*" title="Ukuran file maksimal 2MB" />
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input class="form-control" type="text" value="<?= user()->username; ?>" name="username" type="text" class="form-control" id="username" disabled readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="emain" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input class="form-control" type="text" value="<?= user()->email; ?>" name="email" type="text" class="form-control" id="email" disabled readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="full_name" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="full_name" type="text" class="form-control" id="full_name" value="<?= user()->full_name; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="user_about" class="col-md-4 col-lg-3 col-form-label">About</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <textarea class="form-control" name="user_about" id="user_about" rows="3"><?= user()->user_about; ?></textarea>
                                                        </div>
                                                    </div>


                                                    <div class="text-center">
                                                        <button type="submit" id="update-button" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form><!-- End Change my Data -->

                                            </div>



                                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                                <!-- Change Password Form -->

                                                <?php $validation = \Config\Services::validation(); ?>

                                                <form action="/MyProfile/updatePassword" method="post" enctype="multipart/form-data" id="password-form" autocomplete="off">

                                                    <input type="hidden" class="form-control" for="id" id="id" name="id" value="<?= user()->id; ?>">

                                                    <!-- <div class="row mb-3">
                                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="currentPassword" type="password" class="form-control <?= ($validation->hasError('currentPassword')) ? 'is-invalid' : ''; ?>" id="currentPassword" required>
                                                            <div class="invalid-feedback">
                                                                <?= $validation->getError('currentPassword'); ?>
                                                            </div>
                                                        </div>
                                                    </div> -->

                                                    <div class="row mb-3">
                                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="newpassword" type="password" class="form-control <?= ($validation->hasError('newpassword')) ? 'is-invalid' : ''; ?>" id="newpassword" required>
                                                            <div class="invalid-feedback">
                                                                <?= $validation->getError('newpassword'); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Masukkan Ulang Password Baru</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="renewpassword" type="password" class="form-control <?= ($validation->hasError('renewpassword')) ? 'is-invalid' : ''; ?>" id="renewpassword" required>
                                                            <div class="invalid-feedback">
                                                                <?= $validation->getError('renewpassword'); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                                    </div>
                                                </form><!-- End Change Password Form -->

                                            </div>

                                        </div><!-- End Bordered Tabs -->

                                    </div>
                                </div>

                            </div>


                        </div>
                    </section>

                </div>

            </main>

            <!-- FOOTER -->
            <?= $this->include('_Layout/_template/_admin/footer'); ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="/js/scripts.js"></script>

    <?php if (session()->getFlashdata('success')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?= session()->getFlashdata('success'); ?>',
                timer: 2000,
            });
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session()->getFlashdata('error'); ?>',
                timer: 2000,
            });
        </script>
    <?php endif; ?>

    <script>
        // Get a file input reference
        const input = document.querySelector('input[type="file"]');
        FilePond.registerPlugin(
            FilePondPluginImageCrop,
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize);
        // Create a FilePond instance
        FilePond.create(input, {
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
            maxFileSize: '2MB',
            labelIdle: `Tarik & Taruh Gambar Disini Atau <span class="filepond--label-action">Browse</span>`,
            storeAsFile: true,
            allowMultiple: false,
            credits: false,
            labelMaxFileSize: 'Maximum {filesize}',
            stylePanelLayout: 'compact circle',
            imagePreviewHeight: 100,
            imageCropAspectRatio: '1:1',
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 200,
            styleLoadIndicatorPosition: 'center bottom',
            onerror: (error) => {
                alert('Ukuran gambar maksimal 2MB');
                input.value = '';
            }
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#password-form').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var id = form.find('input[name="id"]').val();
                var currentPassword = form.find('input[name="currentPassword"]').val();
                var newPassword = form.find('input[name="newpassword"]').val();
                var renewPassword = form.find('input[name="renewpassword"]').val();
                $.ajax({
                    url: '/MyProfile/updatePassword',
                    type: 'POST',
                    data: {
                        id: id,
                        currentPassword: currentPassword,
                        newPassword: newPassword,
                        renewPassword: renewPassword
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Password updated successfully.',
                                icon: 'success'
                            });
                            form[0].reset();
                        } else {
                            Swal.fire({
                                title: 'Failed!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to update password.',
                            icon: 'error'
                        });
                    }
                });
            });
        });
    </script>


</body>

</html>