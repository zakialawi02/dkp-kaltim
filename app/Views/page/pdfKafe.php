<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

    <title>PDF Document</title>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        $.ajax({
            url: "/api/aprv",
            dataType: "json",
            success: function(data) {
                // Memasukkan properti GeoJSON ke dalam tabel
                data.features.forEach(function(feature, index) {
                    var properties = feature.properties;
                    // console.log(properties);
                    var row = $("<tr></tr>");
                    var noCell = $("<td></td>").text(index + 1);
                    row.append(noCell);
                    var namaKafeCell = $("<td></td>").text(properties.nama_kafe);
                    row.append(namaKafeCell);
                    var alamatKafeCell = $("<td></td>").text(properties.alamat_kafe);
                    row.append(alamatKafeCell);
                    var latitude = parseFloat(properties.latitude);
                    var longitude = parseFloat(properties.longitude);
                    var koordinat = latitude.toFixed(6) + ", " + longitude.toFixed(6);
                    var koordinatCell = $("<td></td>").text(koordinat);
                    row.append(koordinatCell);
                    var instagramKafe = properties.instagram_kafe;
                    if (instagramKafe) {
                        instagramKafe = "@" + instagramKafe;
                    } else {
                        instagramKafe = "-";
                    }
                    var instagramCell = $("<td></td>").text(instagramKafe);
                    row.append(instagramCell);
                    const jsonString = properties.jam_oprasional;
                    var jamOperasional = JSON.parse(jsonString[0]);
                    // Menggabungkan waktu operasional yang sama
                    var jamOperasionalCell = $("<td></td>");
                    var mergedOperational = [];

                    for (var i = 0; i < jamOperasional.length; i++) {
                        var hari = jamOperasional[i].hari;
                        var openTime = jamOperasional[i].open_time;
                        var closeTime = jamOperasional[i].close_time;
                        // Cek jika waktu operasional sama dengan hari sebelumnya
                        if (i > 0 && openTime === jamOperasional[i - 1].open_time && closeTime === jamOperasional[i - 1].close_time) {
                            // Gabungkan dengan hari sebelumnya
                            var lastMerged = mergedOperational[mergedOperational.length - 1];
                            lastMerged.endDay = hari;
                        } else {
                            // Tambahkan waktu operasional baru
                            mergedOperational.push({
                                startDay: hari,
                                endDay: hari,
                                openTime: openTime,
                                closeTime: closeTime
                            });
                        }
                    }
                    // Format dan tambahkan ke dalam jamOperasionalCell
                    mergedOperational.forEach(function(operational, index) {
                        var jamOperasionalText = operational.startDay;
                        if (operational.startDay !== operational.endDay) {
                            jamOperasionalText += " - " + operational.endDay;
                        }
                        var openTimeHHMM = operational.openTime.substring(0, 5);
                        var closeTimeHHMM = operational.closeTime.substring(0, 5);
                        jamOperasionalText += ": " + openTimeHHMM + " - " + closeTimeHHMM;
                        jamOperasionalCell.append(jamOperasionalText);
                        if (index < mergedOperational.length - 1) {
                            jamOperasionalCell.append("<br>");
                        }
                    });
                    row.append(jamOperasionalCell);


                    $("#data-table").append(row);
                });
            }
        });
    </script> -->
    <style>
        #pdf {
            min-height: 10vh;
        }

        table {
            font-size: 12px;
            width: 100%;
            word-wrap: break-word;
            border-collapse: collapse;
            page-break-inside: auto;
            border: 1px solid black;
        }

        th,
        td {
            padding: 4px;
            text-align: left;
            border-bottom: 1px solid black;
        }

        th:first-child,
        td:first-child {
            width: 10px;
        }

        th {
            background-color: #f2f2f2;
            border-right: 1px solid black;
        }

        td {
            border-right: 1px solid black;
        }


        #hari tr {
            width: 22px;
        }

        #titikdua {
            width: 2px;
        }

        .ig {
            width: 12px;
        }

        .kor {
            width: 20px;
        }
    </style>
</head>

<body>

    <section id="pdf">
        <center>
            <h2>Data Kafe Surabaya</h2>
        </center>



        <table id="data-table">
            <tr>
                <th class="no">No</th>
                <th>Nama Kafe</th>
                <th>Alamat kafe</th>
                <th class="kor">Koordinat</th>
                <th>Instagram</th>
                <th class="jm">Jam Oprasional</th>
            </tr>
            <?php $nomor = 1; ?>
            <?php foreach ($tampilKafe as $K) : ?>
                <tr>
                    <td><?= $nomor++; ?></td>
                    <td><?= $K->nama_kafe; ?></td>
                    <td><?= $K->alamat_kafe; ?>, <?= $K->nama_kelurahan; ?>, <?= $K->nama_kecamatan; ?></td>
                    <td><?= number_format($K->latitude, 8); ?>, <?= number_format($K->longitude, 8); ?></td>
                    <td class="ig"><?= empty($K->instagram_kafe) ? "-" : "@" . $K->instagram_kafe; ?></td>
                    <td><?php
                        $jsonString = $K->jam_oprasional;
                        $jamOperasional = json_decode($jsonString, true);
                        usort($jamOperasional, function ($a, $b) {
                            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                            $indexA = array_search($a['hari'], $days);
                            $indexB = array_search($b['hari'], $days);
                            return $indexA - $indexB;
                        });

                        $mergedOperational = [];
                        $mergedOperational[] = [
                            'startDay' => $jamOperasional[0]['hari'],
                            'endDay' => $jamOperasional[0]['hari'],
                            'openTime' => $jamOperasional[0]['open_time'],
                            'closeTime' => $jamOperasional[0]['close_time']
                        ];
                        for ($i = 1; $i < count($jamOperasional); $i++) {
                            $hari = $jamOperasional[$i]['hari'];
                            $openTime = $jamOperasional[$i]['open_time'];
                            $closeTime = $jamOperasional[$i]['close_time'];
                            if ($openTime === $jamOperasional[$i - 1]['open_time'] && $closeTime === $jamOperasional[$i - 1]['close_time']) {
                                $lastMerged = &$mergedOperational[count($mergedOperational) - 1];
                                $lastMerged['endDay'] = $hari;
                            } else {
                                $mergedOperational[] = [
                                    'startDay' => $hari,
                                    'endDay' => $hari,
                                    'openTime' => $openTime,
                                    'closeTime' => $closeTime
                                ];
                            }
                        }
                        foreach ($mergedOperational as $index => $operational) {
                            $jamOperasionalText = $operational['startDay'];
                            if ($operational['startDay'] !== $operational['endDay']) {
                                $jamOperasionalText .= " - " . $operational['endDay'];
                            }
                            $openTimeHHMM = isset($operational['openTime']) ? substr($operational['openTime'], 0, 5) : 'Tutup';
                            $closeTimeHHMM = isset($operational['closeTime']) ? substr($operational['closeTime'], 0, 5) : 'Tutup';
                            if ($openTimeHHMM == 'Tutup') {
                                $jamOperasionalText .= ": " . "<br>" . $openTimeHHMM;
                            } else {
                                $jamOperasionalText .= ": " . "<br>" . $openTimeHHMM . " - " . $closeTimeHHMM;
                            }
                            echo $jamOperasionalText . "<br>";
                        }

                        ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>


        <!-- <table id="data-table">
            <tr>
                <th class="no">No</th>
                <th>Nama Kafe</th>
                <th>Alamat kafe</th>
                <th>Koordinat</th>
                <th>Instagram</th>
                <th>Jam Oprasional</th>
            </tr>

        </table> -->



    </section>






</body>

</html>