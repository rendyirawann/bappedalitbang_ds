<?php

use coderius\lightbox2\Lightbox2;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Map GIS Control';
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
                            <li class="breadcrumb-item" aria-current="page">Map GIS Control - Draw</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Map GIS Control - Draw</h2>
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
                        <h1>Map GIS Control - Draw</h1>

                        <!-- Form Get Coordinate -->
                        <h3>Get Coordinate Location</h3>
                        <form id="coordinateForm">
                            <div>
                                <label>Latitude Marker Drag:</label>
                                <div class="input-group">
                                    <input type="text" id="dragLatitude" class="form-control" disabled>
                                    <div class="input-group-append">
                                        <button type="button" id="copyLatitude" class="btn btn-outline-secondary mx-3"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Longitude Marker Drag:</label>
                                <div class="input-group">
                                    <input type="text" id="dragLongitude" class="form-control" disabled>
                                    <div class="input-group-append">
                                        <button type="button" id="copyLongitude" class="btn btn-outline-secondary mx-3"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- Tombol untuk menambahkan marker yang di-drag -->
                            <button type="button" id="getCoordinateButton" class="btn btn-info mt-2"><i data-feather="target"></i> Get Coordinate</button>
                            <!-- Tombol untuk reset marker -->
                            <button type="button" id="resetCoordinateButton" class="btn btn-danger mt-2"><i data-feather="refresh-ccw"></i> Reset Coordinate</button>
                        </form>

                        <button type="button" id="printMapButton" class="btn btn-secondary mt-2"><i data-feather="printer"></i> Print Map</button>

                        <!-- Map Container -->
                        <div id="map" style="height: 500px; margin-top: 20px;"></div>

                        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
                        <script src="https://unpkg.com/leaflet-streetview/dist/leaflet-streetview.js"></script> <!-- Pastikan Anda menyertakan ini -->

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                var maxCoordinates = 6;
                                var draggableMarker;

                                // Inisialisasi peta
                                var map = L.map('map').setView([-6.1751, 106.8650], 13); // Koordinat Jakarta

                                // Menambahkan tile layer dari OpenStreetMap dan Mapbox
                                var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    maxZoom: 19,
                                    attribution: '© OpenStreetMap contributors'
                                }).addTo(map);

                                var osmHOT = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
                                    maxZoom: 19,
                                    attribution: '© OpenStreetMap contributors, Tiles style by Humanitarian OpenStreetMap Team hosted by OpenStreetMap France'
                                });

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

                                var markerLayers = [];

                                // Fungsi untuk menambahkan marker yang dapat di-drag
                                function addDraggableMarker(latlng) {
                                    if (draggableMarker) {
                                        map.removeLayer(draggableMarker);
                                    }

                                    draggableMarker = L.marker(latlng, {
                                        draggable: 'true'
                                    }).addTo(map);

                                    // Event listener untuk meng-update koordinat saat marker di-drag
                                    draggableMarker.on('dragend', function(event) {
                                        var marker = event.target;
                                        var position = marker.getLatLng();

                                        // Update nilai input latitude dan longitude
                                        document.getElementById('dragLatitude').value = position.lat.toFixed(6);
                                        document.getElementById('dragLongitude').value = position.lng.toFixed(6);
                                    });
                                }

                                // Fungsi untuk menyalin nilai dari input ke clipboard
                                function copyToClipboard(value) {
                                    // Buat elemen textarea sementara
                                    var tempInput = document.createElement("textarea");
                                    tempInput.style.position = "absolute";
                                    tempInput.style.left = "-9999px";
                                    tempInput.style.top = "0";
                                    tempInput.value = value;
                                    document.body.appendChild(tempInput);
                                    tempInput.select();
                                    tempInput.setSelectionRange(0, 99999); /* For mobile devices */

                                    try {
                                        var successful = document.execCommand('copy');
                                        var msg = successful ? 'Copied the text: ' + value : 'Unable to copy text';
                                        alert(msg);
                                    } catch (err) {
                                        console.error('Error copying text: ', err);
                                        alert('Error copying text: ' + err);
                                    } finally {
                                        document.body.removeChild(tempInput); // Hapus elemen textarea sementara
                                    }
                                }

                                // Fungsi untuk mencetak peta
                                function printMap() {
                                    var mapContainer = document.getElementById('map');
                                    var printWindow = window.open('', '', 'width=800, height=600');
                                    printWindow.document.write('<html><head><title>Print Result Map</title>');
                                    printWindow.document.write('<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />');
                                    printWindow.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />');
                                    printWindow.document.write('<script src="https://unpkg.com/leaflet/dist/leaflet.js"></' + 'script>');
                                    printWindow.document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></' + 'script>');
                                    printWindow.document.write('<style>body { margin: 0; } #map { width: 100%; height: 100%; }</style>');
                                    printWindow.document.write('</head><body>');
                                    printWindow.document.write(mapContainer.outerHTML);
                                    printWindow.document.write('</body></html>');
                                    printWindow.document.close();
                                    printWindow.onload = function() {
                                        printWindow.focus();
                                        printWindow.print();
                                        printWindow.close();
                                    };
                                }

                                // Tambahkan event listener untuk tombol print
                                document.getElementById('printMapButton').addEventListener('click', printMap);

                                // Menginisialisasi Leaflet Draw
                                var drawnItems = new L.FeatureGroup();
                                map.addLayer(drawnItems);

                                var drawControl = new L.Control.Draw({
                                    edit: {
                                        featureGroup: drawnItems,
                                        remove: true
                                    },
                                    draw: {
                                        polygon: true,
                                        polyline: true,
                                        rectangle: true,
                                        circle: true,
                                        marker: true
                                    }
                                });
                                map.addControl(drawControl);

                                // Event listener untuk menangani objek yang baru digambar
                                map.on(L.Draw.Event.CREATED, function(event) {
                                    var layer = event.layer;

                                    drawnItems.addLayer(layer);

                                    if (layer instanceof L.Marker) {
                                        layer.on('dragend', function() {
                                            var latLng = layer.getLatLng();
                                            document.getElementById('dragLatitude').value = latLng.lat;
                                            document.getElementById('dragLongitude').value = latLng.lng;
                                        });
                                    }
                                });

                                // Event listener untuk tombol "Get Coordinate"
                                document.getElementById('getCoordinateButton').addEventListener('click', function() {
                                    map.on('click', function(event) {
                                        addDraggableMarker(event.latlng);

                                        // Update nilai input latitude dan longitude
                                        document.getElementById('dragLatitude').value = event.latlng.lat.toFixed(6);
                                        document.getElementById('dragLongitude').value = event.latlng.lng.toFixed(6);
                                    });
                                });

                                // Event listener untuk tombol "Reset Coordinate"
                                document.getElementById('resetCoordinateButton').addEventListener('click', function() {
                                    if (draggableMarker) {
                                        map.removeLayer(draggableMarker);
                                        draggableMarker = null;
                                    }

                                    // Kosongkan nilai input latitude dan longitude
                                    document.getElementById('dragLatitude').value = '';
                                    document.getElementById('dragLongitude').value = '';
                                });

                                // Event listener untuk tombol salin latitude
                                document.getElementById('copyLatitude').addEventListener('click', function() {
                                    var latitudeValue = document.getElementById('dragLatitude').value;
                                    copyToClipboard(latitudeValue);
                                });

                                // Event listener untuk tombol salin longitude
                                document.getElementById('copyLongitude').addEventListener('click', function() {
                                    var longitudeValue = document.getElementById('dragLongitude').value;
                                    copyToClipboard(longitudeValue);
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>