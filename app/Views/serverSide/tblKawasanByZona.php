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
                <td><?= esc($K->kode_kawasan); ?></td>
                <td><?= esc($K->nama_zona); ?></td>
                <td>
                    <div class="d-inline-flex gap-1">
                        <div class="btn-group mr-2" role="group" aria-label="First group">
                            <form action="/admin/" method="post">
                                <button type="button" class="asbn btn btn-primary bi bi-pencil-square" data-bs-toggle="modal" data-bs-target="#modalEdit" onclick="editkan(<?= $K->id_znkwsn; ?>)"></button>
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
    new DataTable('#datatablesSimples');
</script>