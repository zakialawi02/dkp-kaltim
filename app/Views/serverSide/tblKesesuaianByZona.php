<table id="datatablesSimple" class="table table-striped row-border hover" style="width: 100%;">
    <thead>
        <tr>
            <th>#</th>
            <th>Zona</th>
            <th>Sub Zona</th>
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
                <td><?= $K->nama_zona; ?></td>
                <td><?= $K->sub_zona ?? "-"; ?></td>
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
<script>
    new DataTable('#datatablesSimple');
</script>