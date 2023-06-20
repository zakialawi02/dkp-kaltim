<?php foreach ($getFoto as $fotoKafe) { ?>
    <div class="img-box" id="imgb_<?= $fotoKafe->id; ?>">
        <img id="image" class="img-kafeEdit" src="<?= base_url('/img/kafe/' . $fotoKafe->nama_file_foto); ?>">
        <a href="javascript:void(0);" class="dellbut badge bg-danger btn-delete" data-id="<?= $fotoKafe->id; ?>" onclick=" deleteImage('<?= $fotoKafe->id; ?>')">Hapus</a>
    </div>
<?php } ?>