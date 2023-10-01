<?php if ($dataFile != null) : ?>
    <?php foreach ($dataFile as $file) : ?>
        <div class="card mb-3" style="max-width: 500px;">
            <div class="card-body file">
                <p class="card-text"><button type="button" class="asbn btn btn-danger bi bi-trash3-fill me-2" onclick="hapusFile('<?= $file->uploadFiles; ?>')"></button><a href="/dokumen/upload-dokumen/<?= $file->uploadFiles; ?>" target="_blank"><?= $file->uploadFiles; ?></a></p>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>