<?php

use coderius\lightbox2\Lightbox2;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\DataSampah[] $dataSampah */
/** @var backend\models\SampahDokumen[] $sampahDokumens */

$this->title = 'View All Markers';
$this->params['breadcrumbs'][] = ['label' => 'Data Sampah', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

echo Lightbox2::widget([
    'clientOptions' => [
        'resizeDuration' => 200,
        'wrapAround' => true,
    ],
]);
?>

<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index']) ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= Url::to(['/data-sampah/index']) ?>">Data Sampah</a></li>
                            <li class="breadcrumb-item" aria-current="page">View All Markers</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">View All Markers</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-lg-12">
                <!-- Basic Inputs -->
                <div class="card">
                    <div class="card-body">
                        <h1>View All Markers</h1>
                    </div>

<!-- Container untuk tombol Show/Hide List dan peta -->
<div id="map-container">
    <!-- Buttons untuk show/hide kontrol daftar -->
    <button class="btn btn-info" id="toggleIpaldListButton" style="margin: 10px;">Show/Hide IPALD List</button>
    <button class="btn btn-info" id="toggleSampahListButton" style="margin: 10px;">Show/Hide Sampah List</button>

    <!-- Map Container -->
    <div id="map" style="height: 500px; margin-top: 20px;"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var markers = <?= $markers ?>; // Mengambil data markers dari kontroler
    var dokumenMap = <?= $dokumenMap ?>; // Mengambil data dokumen dari kontroler

    // Inisialisasi tile layer dari OpenStreetMap dan OpenStreetMap HOT
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    });

    var osmHOT = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors, Tiles style by Humanitarian OpenStreetMap Team hosted by OpenStreetMap France'
    });

    // Inisialisasi tile layer dari Mapbox (opsional)
    var accessToken = 'pk.eyJ1IjoicmVuZHk5MDA4IiwiYSI6ImNseDk0cWgxazF1bDYyaXE5enF5NjdoMm4ifQ.W3czFB6jz042qcOdE44e8Q';

    var satellite = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/satellite-v9/tiles/{z}/{x}/{y}?access_token=' + accessToken, {
        maxZoom: 19,
        attribution: '© Mapbox, © OpenStreetMap'
    });

    var satelliteStreets = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v11/tiles/{z}/{x}/{y}?access_token=' + accessToken, {
        maxZoom: 19,
        attribution: '© Mapbox, © OpenStreetMap'
    });

    var light = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/light-v10/tiles/{z}/{x}/{y}?access_token=' + accessToken, {
        maxZoom: 19,
        attribution: '© Mapbox, © OpenStreetMap'
    });

    var streets = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token=' + accessToken, {
        maxZoom: 19,
        attribution: '© Mapbox, © OpenStreetMap'
    });

    var dark = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/dark-v10/tiles/{z}/{x}/{y}?access_token=' + accessToken, {
        maxZoom: 19,
        attribution: '© Mapbox, © OpenStreetMap'
    });

    // Ambil data pertama dari markers untuk center dan zoom peta
    var firstIpaldMarker = markers.find(marker => marker.jenis_data === 'data_ipald');

    // Inisialisasi peta dengan center dan zoom level dari data pertama IPALD
    var map = L.map('map', {
        center: [firstIpaldMarker.latitude, firstIpaldMarker.longitude], // Posisi awal peta dari data pertama IPALD
        zoom: 13, // Zoom level awal
        layers: [osm] // Layer default (OpenStreetMap)
    });

    // Membuat ikon dengan warna untuk data_ipald dan data_sampah
    var blueIcon = L.icon({
        iconUrl: '<?= Yii::getAlias('@web/lightapp/assets/images/blue-marker.png') ?>',
        iconSize: [24, 35], // Ukuran ikon
        iconAnchor: [12, 41], // Posisi ikon yang menunjuk ke titik
        popupAnchor: [1, -34] // Posisi popup relatif terhadap ikon
    });

    var redIcon = L.icon({
        iconUrl: '<?= Yii::getAlias('@web/lightapp/assets/images/red-marker.png') ?>',
        iconSize: [24, 35],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34]
    });

    var greenIcon = L.icon({
        iconUrl: '<?= Yii::getAlias('@web/lightapp/assets/images/green-marker.png') ?>',
        iconSize: [24, 35],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34]
    });

    var yellowIcon = L.icon({
        iconUrl: '<?= Yii::getAlias('@web/lightapp/assets/images/yellow-marker.png') ?>',
        iconSize: [24, 35],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34]
    });

    // Menambahkan kontrol layer ke peta
    var baseMaps = {
        "OpenStreetMap": osm,
        "OpenStreetMap HOT": osmHOT,
        "Satellite": satellite,
        "Satellite Streets": satelliteStreets,
        "Light": light,
        "Streets": streets,
        "Dark": dark
    };

    L.control.layers(baseMaps).addTo(map);

    // Membuat array untuk menyimpan semua marker
    var allMarkers = [];

    // Menambahkan semua marker ke peta
    markers.forEach(function (markerData) {
        var icon;
        if (markerData.jenis_data === 'data_ipald') {
            icon = blueIcon; // Marker awal biru untuk data_ipald
        } else if (markerData.jenis_data === 'data_sampah') {
            icon = greenIcon; // Marker awal hijau untuk data_sampah
        }

        var marker = L.marker([markerData.latitude, markerData.longitude], { icon: icon }).addTo(map);

        // Popup content
        var popupContent = '<p>' + markerData.fasilitas + ' / ' + markerData.alamat + '</p>';

        // Tambahkan gambar dari dokumenMap jika ada
        if (dokumenMap[markerData.id]) {
            dokumenMap[markerData.id].forEach(function(dokumen) {
                var imagePath = markerData.jenis_data === 'data_sampah'
                    ? '<?= Yii::getAlias('@web/dokumen/data_sampah_image/') ?>'
                    : '<?= Yii::getAlias('@web/dokumen/data_ipald_image/') ?>';

                popupContent += '<img src="' + imagePath + dokumen.file + '" style="width: 100px; height: auto; margin-top: 5px;" />';
            });
        }

        marker.bindPopup(popupContent);
        allMarkers.push({ id: markerData.id, marker: marker, jenis_data: markerData.jenis_data });
    });

    // Fungsi untuk memindahkan peta ke lokasi tertentu dan menampilkan popup
    window.flyToLocation = function (id) {
        // Reset warna semua marker
        allMarkers.forEach(function (m) {
            var icon;
            if (m.jenis_data === 'data_ipald') {
                icon = blueIcon; // Marker biru untuk data_ipald
            } else if (m.jenis_data === 'data_sampah') {
                icon = greenIcon; // Marker hijau untuk data_sampah
            }
            m.marker.setIcon(icon); // Ganti dengan ikon default
        });

        // Temukan marker yang sesuai berdasarkan ID
        var selectedMarker = allMarkers.find(function (m) {
            return m.id === id;
        });

        // Ubah warna marker menjadi merah atau kuning tergantung pada jenis data
        var selectedIcon;
        if (selectedMarker.jenis_data === 'data_ipald') {
            selectedIcon = redIcon; // Marker merah untuk data_ipald
        } else if (selectedMarker.jenis_data === 'data_sampah') {
            selectedIcon = yellowIcon; // Marker kuning untuk data_sampah
        }

        selectedMarker.marker.setIcon(selectedIcon);

        map.setView(selectedMarker.marker.getLatLng(), 13);
        selectedMarker.marker.openPopup();

        // Sembunyikan kontrol daftar setelah item diklik
        var listContainer = document.querySelector('.leaflet-control-custom');
        listContainer.style.display = 'none';
    };

    // Membuat kontrol custom untuk daftar marker
    var customControl = L.Control.extend({
        options: {
            position: 'topright' // Control position
        },
        onAdd: function (map) {
            var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');

            container.style.backgroundColor = 'white';
            container.style.padding = '10px';
            container.style.width = '600px'; // Lebar kontrol diperlebar
            container.style.maxWidth = '1000px'; // Maksimal lebar kontrol
            container.style.maxHeight = '200px';
            container.style.overflowY = 'auto';
            container.style.display = 'none'; // Awalnya disembunyikan

            // Membuat daftar marker
            var list = document.createElement('ul');
            list.style.listStyle = 'none'; // Menghapus bullet points
            list.style.padding = '0';
            list.style.margin = '0';

            var ipaldList = document.createElement('ul');
            ipaldList.style.listStyle = 'none';
            ipaldList.style.padding = '0';
            ipaldList.style.margin = '0';

            var sampahList = document.createElement('ul');
            sampahList.style.listStyle = 'none';
            sampahList.style.padding = '0';
            sampahList.style.margin = '0';

            markers.forEach(function (markerData) {
                var listItem = document.createElement('li');
                listItem.innerHTML = '<a href="#" onclick="flyToLocation(' + markerData.id + ')">' + markerData.fasilitas + ' / ' + markerData.alamat + '</a>';
                listItem.style.padding = '5px 0'; // Memberikan sedikit padding untuk setiap item
                listItem.style.whiteSpace = 'nowrap';
                listItem.style.overflow = 'hidden'; // Hide overflow text
                listItem.style.textOverflow = 'ellipsis'; // Add ellipsis for overflow text
                listItem.addEventListener('click', function (event) {
                    event.preventDefault();
                    flyToLocation(markerData.id); // Panggil fungsi flyToLocation dengan id marker yang sesuai
                });

                if (markerData.jenis_data === 'data_ipald') {
                    ipaldList.appendChild(listItem);
                } else if (markerData.jenis_data === 'data_sampah') {
                    sampahList.appendChild(listItem);
                }
            });

            container.appendChild(ipaldList);
            container.appendChild(sampahList);
            return container;
        }
    });

    // Menambahkan kontrol custom ke peta
    var listControl = new customControl();
    map.addControl(listControl);

    // Fungsi untuk menampilkan atau menyembunyikan kontrol daftar
    var toggleIpaldListButton = document.getElementById('toggleIpaldListButton');
    var toggleSampahListButton = document.getElementById('toggleSampahListButton');
    
    toggleIpaldListButton.addEventListener('click', function () {
        var listContainer = document.querySelector('.leaflet-control-custom');
        if (listContainer.style.display === 'none' || listContainer.style.display === '') {
            listContainer.style.display = 'block';
            // Tampilkan hanya daftar IPALD
            listContainer.firstChild.style.display = 'block'; // IPALD list
            listContainer.lastChild.style.display = 'none'; // Sampah list
        } else {
            listContainer.style.display = 'none';
        }
    });

    toggleSampahListButton.addEventListener('click', function () {
        var listContainer = document.querySelector('.leaflet-control-custom');
        if (listContainer.style.display === 'none' || listContainer.style.display === '') {
            listContainer.style.display = 'block';
            // Tampilkan hanya daftar Sampah
            listContainer.firstChild.style.display = 'none'; // IPALD list
            listContainer.lastChild.style.display = 'block'; // Sampah list
        } else {
            listContainer.style.display = 'none';
        }
    });
});
</script>








                   </div>
               </div>
           </div>
       </div>
   </div>
