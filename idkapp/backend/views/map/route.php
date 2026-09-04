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

<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index']) ?>">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Map GIS Control - Route</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Map GIS Control - Route</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1>Map GIS Control</h1>

                        <h3>Add Routing</h3>
                        <form id="routingForm">
                            <div>
                                <label>Starting Point Latitude:</label>
                                <input type="text" id="startLatitude" class="form-control">
                                <label>Starting Point Longitude:</label>
                                <input type="text" id="startLongitude" class="form-control">
                            </div>
                            <div>
                                <label>End Point Latitude:</label>
                                <input type="text" id="endLatitude" class="form-control">
                                <label>End Point Longitude:</label>
                                <input type="text" id="endLongitude" class="form-control">
                            </div>
                            <button type="button" id="searchRouteButton" class="btn btn-success mt-2"><i data-feather="search"></i> Find Route</button>
                            <button type="button" id="resetRouteButton" class="btn btn-danger mt-2"><i data-feather="refresh-ccw"></i> Reset Route</button>
                        </form>

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
                            <button type="button" id="getCoordinateButton" class="btn btn-info mt-2"><i data-feather="target"></i> Get Coordinate</button>
                            <button type="button" id="resetMarkerButton" class="btn btn-danger mt-2"><i data-feather="refresh-ccw"></i> Reset Coordinate</button>
                        </form>


                        <button type="button" id="printMapButton" class="btn btn-secondary mt-2"><i data-feather="printer"></i> Print Map</button>

                        <div id="map" style="height: 500px; margin-top: 20px;"></div>

                        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                var maxMarkerCoordinates = 6;
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
                                var routingControl;

                                function searchRoute() {
                                    if (routingControl) {
                                        map.removeControl(routingControl);
                                    }

                                    var startLat = parseFloat(document.getElementById('startLatitude').value);
                                    var startLng = parseFloat(document.getElementById('startLongitude').value);
                                    var endLat = parseFloat(document.getElementById('endLatitude').value);
                                    var endLng = parseFloat(document.getElementById('endLongitude').value);

                                    if (!isNaN(startLat) && !isNaN(startLng) && !isNaN(endLat) && !isNaN(endLng)) {
                                        routingControl = L.Routing.control({
                                            waypoints: [
                                                L.latLng(startLat, startLng),
                                                L.latLng(endLat, endLng)
                                            ],
                                            routeWhileDragging: true
                                        }).addTo(map);
                                    }
                                }

                                function addDraggableMarker(latlng) {
                                    if (draggableMarker) {
                                        map.removeLayer(draggableMarker);
                                    }

                                    draggableMarker = L.marker(latlng, {
                                        draggable: 'true'
                                    }).addTo(map);
                                    draggableMarker.on('dragend', function(event) {
                                        var marker = event.target;
                                        var position = marker.getLatLng();

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
                                    printWindow.document.write('<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />');
                                    printWindow.document.write('<script src="https://unpkg.com/leaflet/dist/leaflet.js"></' + 'script>');
                                    printWindow.document.write('<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></' + 'script>');
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

                                document.getElementById('searchRouteButton').addEventListener('click', function() {
                                    searchRoute();
                                });

                                document.getElementById('resetRouteButton').addEventListener('click', function() {
                                    if (routingControl) {
                                        map.removeControl(routingControl);
                                    }
                                    document.getElementById('startLatitude').value = '';
                                    document.getElementById('startLongitude').value = '';
                                    document.getElementById('endLatitude').value = '';
                                    document.getElementById('endLongitude').value = '';
                                });

                                document.getElementById('getCoordinateButton').addEventListener('click', function() {
                                    map.on('click', function(event) {
                                        var latlng = event.latlng;
                                        addDraggableMarker(latlng);
                                        document.getElementById('dragLatitude').value = latlng.lat.toFixed(6);
                                        document.getElementById('dragLongitude').value = latlng.lng.toFixed(6);
                                    });
                                });

                                document.getElementById('resetMarkerButton').addEventListener('click', function() {
                                    if (draggableMarker) {
                                        map.removeLayer(draggableMarker);
                                    }
                                    document.getElementById('dragLatitude').value = '';
                                    document.getElementById('dragLongitude').value = '';
                                });

                                document.getElementById('copyLatitude').addEventListener('click', function() {
                                    var latitudeValue = document.getElementById('dragLatitude').value;
                                    copyToClipboard(latitudeValue);
                                });

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