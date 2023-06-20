<div class="map" id="map"></div>

<script>
    // Base map
    var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    });

    var peta2 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/satellite-v9'
    });

    var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    var peta4 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiNjg2MzUzMyIsImEiOiJjbDh4NDExZW0wMXZsM3ZwODR1eDB0ajY0In0.6jHWxwN6YfLftuCFHaa1zw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/dark-v10'
    });

    // set frame view

    <?php foreach ($tampilData as $D) : ?>
        var map = L.map('map', {
            center: [<?= $D->coordinat_wilayah; ?>],
            zoom: <?= $D->zoom_view; ?>,
            layers: [peta1],
            gestureHandling: true,
        })
    <?php endforeach ?>

    // controller
    var baseLayers = {
        "Map": peta1,
        "Satellite": peta2,
        "OSM": peta3,
    };

    L.control.layers(baseLayers).addTo(map);
    L.control.mousePosition().addTo(map);
    L.control.scale().addTo(map);


    // set marker place
    var locKafe = L.icon({
        iconUrl: '<?= base_url(); ?>/leaflet/icon/restaurant_breakfast.png',
        iconSize: [30, 30],
        iconAnchor: [18.5, 30], // point of the icon which will correspond to marker's location
        popupAnchor: [0, -28] // point from which the popup should open relative to the iconAnchor
    });

    <?php foreach ($tampilKafe as $K) : ?>
        L.marker([<?= $K->latitude; ?>, <?= $K->longitude; ?>], {
            icon: locKafe
        }).addTo(map).bindPopup("<b><?= $K->nama_kafe; ?></b></br><?= $K->alamat_kafe; ?>");
    <?php endforeach ?>
</script>