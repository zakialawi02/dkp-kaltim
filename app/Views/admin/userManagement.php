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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                    <h1 class="mt-2 mb-3">Kelola Pengguna</h1>

                    <div class="card mb-4">
                        <div class="card-body">

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Tambah</button>

                            <!-- Modal -->
                            <div class="modal fade mt-5" id="exampleModal" tabindex="-1" style="z-index: 2001 ;" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form id="form" name="form" action="/user/tambah" method="post" enctype="multipart/form-data" class="row g-3" autocomplete="off" id="addUserForm">

                                                <?= csrf_field(); ?>

                                                <div class="form-group">
                                                    <label for="username" class="col-form-label">Username</label>
                                                    <input type="text" class="form-control " name="username" id="username" pattern="^\S{5,}$" title="Minimum 5 karakter & Tidak Boleh Mengandung Spasi" required>
                                                    <div id="usernameError" class="error form-text" style="color: red;"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="full_name" class="col-form-label">Full Name</label>
                                                    <input type="text" class="form-control" name="full_name" id="full_name">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email" class="col-form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$" title="Masukkan Email Yang Benar" required>
                                                    <div id="emailError" class="error form-text" style="color: red;"></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="password_hash" class="col-form-label">Password</label>
                                                    <input type="password" class="form-control" name="password_hash" id="password_hash" autocomplete="off" pattern="^.{6,}$" title="Minimum 6 karakter" required>
                                                    <div id="passwordError" class="error form-text" style="color: red;"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="role" class="col-form-label">Role</label>
                                                    <select class="form-control" name="role" id="role" required>
                                                        <option value="">--Pilih Role--</option>
                                                        <?php foreach ($auth_groups as $key => $value) : ?>
                                                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id="tombol" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <table id="datatablesSimple" class="table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Tanggal Gabung</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <th scope="row"><?= $i++; ?></th>
                                            <td><?= esc($user->username); ?></td>
                                            <td><?= date('d M Y', strtotime($user->created_at)); ?></td>
                                            <td><?= esc($user->full_name); ?></td>
                                            <td><?= esc($user->email); ?></td>
                                            <td><span class="badge bg-<?= ($user->name == 'Admin' or $user->name == 'SuperAdmin') ? 'info' : 'secondary'; ?>"> <?= $user->name; ?> </span></td>
                                            <td><span class="badge bg-<?= ($user->active == '0') ? 'danger' : 'success'; ?>"> <?= ($user->active == '0') ? 'inactive' : 'active'; ?> </span></td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="asbn btn btn-primary bi bi-pencil-square" data-bs-toggle="modal" data-bs-target="#editUserRole-<?= $user->userid ?>"></button>

                                                <!-- Modal -->
                                                <div class="modal fade mt-5" id="editUserRole-<?= $user->userid ?>" tabindex="-1" style="z-index: 2001 ;" aria-labelledby="exampleModalLabels" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabels">Edit User</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <form action="/user/updateUser" method="post" enctype="multipart/form-data" class="row g-3" autocomplete="off" id="updateUserForm">
                                                                    <?= csrf_field(); ?>

                                                                    <input type="hidden" class="form-control" for="userid" id="userid" name="userid" value="<?= $user->userid ?>">

                                                                    <div class="form-group">
                                                                        <label for="username" class="col-form-label">Username</label>
                                                                        <input type="text" class="form-control " name="username" id="username" value="<?= $user->username ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="full_name" class="col-form-label">Full Name</label>
                                                                        <input type="text" class="form-control " name="full_name" id="full_name" value="<?= esc($user->full_name) ?>">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="email" class="col-form-label">Email</label>
                                                                        <input type="email" class="form-control " name="email" id="email" value="<?= $user->email ?>" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="password_hash" class="col-form-label">Password</label>
                                                                        <input type="password" class="form-control" name="password_hash" id="password_hash" autocomplete="off">
                                                                        <div id="emailHelp" class="form-text">Kosongkan jika tidak ingin mengganti password</div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="role" class="col-form-label">Role</label>
                                                                        <select class="form-control " name="role" id="role" required>
                                                                            <option value="">--Pilih Role--</option>
                                                                            <?php foreach ($auth_groups as $key => $value) : ?>
                                                                                <option value="<?= $value['id'] ?>" <?= $value['id'] == $user->group_id ? "selected" : null ?>><?= $value['name'] ?></option>
                                                                            <?php endforeach ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="active" class="col-form-label">Status</label>
                                                                        <select class="form-control " name="active" id="active" required>
                                                                            <option value="">--Status--</option>
                                                                            <?php $active = $user->active; ?>
                                                                            <option value="1" <?php if ($active == 1) echo "selected"; ?>>Active</option>
                                                                            <option value="0" <?php if ($active == 0) echo "selected"; ?>>Inactive</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <form id="delete-form-<?= $user->userid ?>" action="/user/delete/<?= $user->userid ?>/<?= $user->username; ?>" method="post">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="button" class="asbn btn btn-danger bi bi-trash delete-btn" data-id="<?= $user->userid ?>" <?= ($user->name == 'SuperAdmin' && user_id() != $user->userid) ? "disabled" : ""; ?>></button>
                                                    </form>
                                                </div>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/816b3ace5c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js "></script>

    <!-- Template Main JS File -->
    <script src="/js/datatables-simple-demo.js"></script>
    <script src="/js/scripts.js"></script>


    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var userId = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin ingin menghapus data ini?',
                    text: "Data yang terkait akan dihapus. Data yang sudah dihapus tidak dapat dikembalikan!",
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

    <?php if (session()->getFlashdata('success')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?= session()->getFlashdata('success'); ?>',
                timer: 3000,
            });
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session()->getFlashdata('error'); ?>',
                timer: 3000,
            });
        </script>
    <?php endif; ?>


</body>

</html>