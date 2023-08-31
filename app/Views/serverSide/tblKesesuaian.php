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
                                <button type="button" class="asbn btn btn-primary bi bi-pencil-square" onclick="editkan(<?= $K->id; ?>, <?= $K->id_znkwsn; ?>)"></button>
                            </form>
                        </div>
                        <div class="btn-group mr-2" role="group" aria-label="First group">
                            <form action="/admin/" method="post">
                                <button type="button" class="asbn btn btn-danger bi bi-trash" onclick="hapuskan(<?= $K->id_znkwsn; ?>)"></button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<script>
    new DataTable('#datatablesSimple');
</script>