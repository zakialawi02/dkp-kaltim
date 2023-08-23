<?php
$hasil = $url;
if ($hasil['features'] == null) {
    $namaObjek = "Maaf, titik yang anda pilih berada diluar area kawasan.";
    $kawasan = "-";
    $kode = "-";
} else {
    $attribute = $hasil['features'][0]['properties'];
    $namaObjek = $attribute['NAMOBJ'];
    $kawasan = $attribute['ORDE01'];
    $kode = $attribute['KODKWS'];
}
// dd($hasil);
?>

<div class="hasilKonten">

    <div class="table-responsive">
        <table class="table">
            <tr>
                <td class="thead">Nama Objek</td>
                <td class="tspace">:</td>
                <td class="kawasan"><?= $namaObjek; ?></td>
            </tr>
            <tr>
                <td class="thead">Kawasan</td>
                <td class="tspace">:</td>
                <td class="zona"><?= $kawasan; ?></td>
            </tr>
            <tr>
                <td class="thead">Kode</td>
                <td class="tspace">:</td>
                <td class="subzona"><?= $kode; ?></td>
            </tr>
        </table>
    </div>


    <form class="row g-3" action="/data/isiAjuan" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <input type="hidden" class="form-control" for="koordinat" id="koordinat" name="koordinat" value="">
        <input type="hidden" class="form-control" for="geojson" id="geojson" name="geojson" value="">

        <div class="form-group">
            <label class="col-md-12 mb-2">Jenis Kegiatan</label>
            <select class="form-select" id="pilihKegiatan" name="kegiatan" for="kegiatan" style="width: 100%;" required>
                <option></option>
                <?php foreach ($jenisKegiatan as $K) : ?>
                    <option value="<?= $K->id_kegiatan; ?>"><?= $K->nama_kegiatan; ?></option>
                <?php endforeach ?>
            </select>
        </div>


        <div class="feedback">Keterangan:</div>
        <div class="info">
            <div class="feedback" id="showKegiatan"> </div>
        </div>

        <button type="submit" id="lanjutKirim" class="btn btn-primary">Lanjutkan</button>
    </form>

</div>



<script>
    $(document).ready(function() {
        $('#pilihKegiatan').select2({
            placeholder: "Pilih Jenis Kegiatan",
            allowClear: true
        });
    });
</script>