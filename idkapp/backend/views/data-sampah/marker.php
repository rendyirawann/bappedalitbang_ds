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
                            <li class="breadcrumb-item" aria-current="page">View Markers</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">View Markers</h2>
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
                        <h1>View Markers</h1>
                    </div>

<!-- Container untuk tombol Show/Hide List dan peta -->
<div id="map-container">
    <!-- Button untuk show/hide kontrol daftar -->
    <button class="btn btn-info" id="toggleListButton" style="margin: 10px;">Show/Hide List</button>

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

    // Inisialisasi peta dengan tile layer default (OpenStreetMap)
    var firstMarker = markers[0];

    var map = L.map('map', {
        center: [firstMarker.latitude, firstMarker.longitude],
        zoom: 13,
        layers: [osm]
    });

    var redIcon = L.icon({
        iconUrl: '<?= Yii::getAlias('@web/lightapp/assets/images/yellow-marker.png') ?>',
        iconSize: [24, 35],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34]
    });

    var blueIcon = L.icon({
        iconUrl: '<?= Yii::getAlias('@web/lightapp/assets/images/green-marker.png') ?>',
        iconSize: [24, 35],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34]
    });

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

    var allMarkers = [];
    markers.forEach(function (markerData) {
        var marker = L.marker([markerData.latitude, markerData.longitude], { icon: blueIcon }).addTo(map);

        var popupContent = '<p>Fasilitas: ' + markerData.fasilitas + ' / ' + markerData.alamat + '</p>' + '<p>Koordinat: ' + markerData.latitude + ', ' + markerData.longitude + '</p>' + 
                    '<a href="https://www.google.com/maps?q=' + markerData.latitude + ',' + markerData.longitude + '" target="_blank">' + 'Lihat di Google Maps</a></p>';

if (dokumenMap[markerData.id]) {
    dokumenMap[markerData.id].forEach(function (dokumen) {
        popupContent += '<div><img src="<?= Yii::getAlias('@web/dokumen/data_sampah_image/') ?>' + dokumen.file + '" style="width:300px;height:150px;margin-bottom:10px;"></div>';
    });
}


        marker.bindPopup(popupContent);
        allMarkers.push({ id: markerData.id, marker: marker });
    });

    window.flyToLocation = function (id) {
        allMarkers.forEach(function (m) {
            m.marker.setIcon(blueIcon);
        });

        var selectedMarker = allMarkers.find(function (m) {
            return m.id === id;
        }).marker;

        selectedMarker.setIcon(redIcon);

        map.setView(selectedMarker.getLatLng(), 13);
        selectedMarker.openPopup();

        var listContainer = document.querySelector('.leaflet-control-custom');
        listContainer.style.display = 'none';
    };

    var customControl = L.Control.extend({
        options: {
            position: 'topright'
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

            var list = document.createElement('ul');
            list.style.listStyle = 'none';
            list.style.padding = '0';
            list.style.margin = '0';
            markers.forEach(function (markerData) {
                var listItem = document.createElement('li');
                listItem.innerHTML = '<a href="#" onclick="flyToLocation(' + markerData.id + ')">' + markerData.fasilitas + ' / ' + markerData.alamat + '</a>';
                listItem.style.padding = '5px 0';
                listItem.style.whiteSpace = 'nowrap';
                listItem.style.overflow = 'hidden';
                listItem.style.textOverflow = 'ellipsis';
                listItem.addEventListener('click', function (event) {
                    event.preventDefault();
                    flyToLocation(markerData.id);
                });
                list.appendChild(listItem);
            });

            container.appendChild(list);
            return container;
        }
    });

    var listControl = new customControl();
    map.addControl(listControl);

    var toggleListButton = document.getElementById('toggleListButton');
    toggleListButton.addEventListener('click', function () {
        var listContainer = document.querySelector('.leaflet-control-custom');
        if (listContainer.style.display === 'none' || listContainer.style.display === '') {
            listContainer.style.display = 'block';
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
