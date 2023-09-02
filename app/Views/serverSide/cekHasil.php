<?php
if ($objectID != null) {
    $id = array_unique($objectID);
    $kawasan = array_unique($kawasan);
    $name = array_unique($objectName);
    $kode = array_unique($kode);
    $orde = array_unique($orde);
    $remark = array_unique($remark);
}
$id = $objectID ?? "";
$kawasan = $kawasan ?? "Maaf, Tidak ada data / Tidak terdeteksi";
$name = $name ?? "Maaf, Tidak ada data / Tidak terdeteksi";
$kode = $kode  ?? "-";
$orde = $orede  ?? "-";
$remark = $remark ?? "-";
// dd($kawasan);
?>
<p class="form-text text-muted">*Zona Yang Saling Tumpang Tindih Dengan Lokasi Geometry</p>
<div class="hasilKonten">
    <div class="table-responsive">
        <table class="table align-middle">
            <tr>
                <td class="thead">Nama Objek</td>
                <td class="tspace">:</td>
                <td class="zona">
                    <?php if ($id == null) : ?>
                        <?= $name; ?>
                    <?php else : ?>
                        <?php foreach ($name as $val) : ?>
                            <?= $val; ?> <br>
                        <?php endforeach ?>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <td class="thead">Kawasan</td>
                <td class="tspace">:</td>
                <td class="kawasan">
                    <?php if ($id == null) : ?>
                        <?= $kawasan; ?>
                    <?php else : ?>
                        <?php foreach ($kawasan as $val) : ?>
                            <?= $val; ?> <br>
                        <?php endforeach ?>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <td class="thead">Kode</td>
                <td class="tspace">:</td>
                <td class="kode">
                    <?php if ($id == null) : ?>
                        <?= $kode; ?>
                    <?php else : ?>
                        <?php foreach ($kode as $val) : ?>
                            <?= $val; ?> <br>
                        <?php endforeach ?>
                    <?php endif ?>
                </td>
            </tr>
        </table>
    </div>


    <form class="row g-3" action="/data/isiAjuan" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <input type="hidden" class="form-control" for="geojson" id="geojson" name="geojson" value="">
        <input type="hidden" class="form-control" for="getOverlap" id="getOverlap" name="getOverlap" value="">

        <div class="form-group">
            <label class="col-md-12 mb-2">Jenis Kegiatan</label>
            <select class="form-select" id="pilihKegiatan" name="kegiatan" for="kegiatan" style="width: 100%;" onchange="cek()" required>
                <option></option>
                <?php foreach ($jenisKegiatan as $K) : ?>
                    <option value="<?= $K->id_kegiatan; ?>"><?= $K->nama_kegiatan; ?></option>
                <?php endforeach ?>
            </select>
        </div>


        <div class="feedback">Keterangan:</div>
        <div class="info_status">
            <div class="info_status" id="showKegiatan"> - </div>
        </div>

        <?php if (logged_in()) : ?>
            <button type="submit" id="lanjutKirim" class="btn btn-primary lanjutKirim" onclick="kirim()">Lanjutkan</button>
        <?php else : ?>
            <p>Harap Login Untuk Bisa Melakukan Pengajuan Informasi Ruang Laut. <br>Belum Punya Akun? <a href="/register">Daftar Disini</a></p>
            <button type="button" id="lanjutKirim" class="btn btn-primary" disabled>Lanjutkan</button>
        <?php endif ?>
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