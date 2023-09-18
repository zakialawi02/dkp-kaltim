<h6 class="pt-2 pb-2">Zona: <?= $dataKesesuaian[0]->nama_zona ?? "-"; ?></h6>
<table id="datatablesSimples" class="table table-striped row-border hover" style="width: 100%;">
    <thead>
        <tr>
            <th>#</th>
            <th>Zona</th>
            <th>Kawasan</th>
            <th>Nama Kegiatan</th>
            <th>status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1 ?>
        <?php foreach ($dataKesesuaian as $K) : ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $K->nama_zona; ?></td>
                <td><?= $K->kawasan; ?></td>
                <td><?= $K->nama_kegiatan; ?></td>
                <td><?= $K->status; ?></td>
                <td>
                    <div class="d-inline-flex gap-1">
                        <div class="btn-group mr-2" role="group" aria-label="First group">
                            <a href="/admin/zona/edit/<?= $K->id_kesesuaian; ?>" class="asbn btn btn-primary bi bi-pencil-square" role="button"></a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<script>
    new DataTable('#datatablesSimples');
</script>