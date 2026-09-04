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
                            <li class="breadcrumb-item" aria-current="page">Map GIS Control - Circle</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Map GIS Control - Circle</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1>Map GIS Control - Circle</h1>

                        <h3>Add Circle</h3>
                        <form id="circleForm">
                            <div id="circleInputs">
                                <div>
                                    <label>Latitude Circle 1:</label>
                                    <input type="text" id="circleLatitude1" class="form-control">
                                    <label>Longitude Circle 1:</label>
                                    <input type="text" id="circleLongitude1" class="form-control">
                                    <label>Radius Circle 1 (meters):</label>
                                    <input type="number" id="circleRadius1" class="form-control">
                                    <label>Warna Circle 1:</label>
                                    <select id="circleColor1" class="form-control">
                                        <option value="red">Red</option>
                                        <option value="green">Green</option>
                                        <option value="blue">Blue</option>
                                        <option value="yellow">Yellow</option>
                                        <option value="purple">Purple</option>
                                        <option value="orange">Orange</option>
                                        <option value="white">White</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" id="addCircleButton" class="btn btn-primary mt-2"><i data-feather="plus-circle"></i> Add Mark Circle</button>
                            <button type="button" id="searchCircleButton" class="btn btn-success mt-2"><i data-feather="search"></i> Find Mark Circle</button>
                            <button type="button" id="resetCircleButton" class="btn btn-danger mt-2"><i data-feather="refresh-ccw"></i> Reset Circle</button>
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
                                var maxCoordinates = 6;
                                var circleCoordinateCount = 1;
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
                                var circleLayers = [];

                                // Fungsi untuk mencari dan menambahkan marker pada koordinat tertentu
                                function searchMarkers() {
                                    // Hapus semua marker sebelumnya
                                    markerLayers.forEach(function(layer) {
                                        map.removeLayer(layer);
                                    });
                                    markerLayers = [];

                                    var coordinates = [];

                                    for (var i = 1; i <= markerCoordinateCount; i++) {
                                        var lat = parseFloat(document.getElementById('markerLatitude' + i).value);
                                        var lng = parseFloat(document.getElementById('markerLongitude' + i).value);

                                        if (!isNaN(lat) && !isNaN(lng)) {
                                            var marker = L.marker([lat, lng]).addTo(map)
                                                .bindPopup('Koordinat: ' + lat + ', ' + lng)
                                                .openPopup();
                                            markerLayers.push(marker);
                                            coordinates.push([lat, lng]);
                                        }
                                    }

                                    if (coordinates.length > 0) {
                                        map.setView(coordinates[0], 13);
                                    }
                                }

                                function searchCircles() {
                                    circleLayers.forEach(function(layer) {
                                        map.removeLayer(layer);
                                    });
                                    circleLayers = [];

                                    var coordinates = [];

                                    for (var i = 1; i <= circleCoordinateCount; i++) {
                                        var lat = parseFloat(document.getElementById('circleLatitude' + i).value);
                                        var lng = parseFloat(document.getElementById('circleLongitude' + i).value);
                                        var radius = parseFloat(document.getElementById('circleRadius' + i).value);
                                        var color = document.getElementById('circleColor' + i).value;

                                        if (!isNaN(lat) && !isNaN(lng) && !isNaN(radius)) {
                                            coordinates.push([lat, lng]);
                                            var circle = L.circle([lat, lng], {
                                                color: color,
                                                fillColor: color,
                                                fillOpacity: 0.5,
                                                radius: radius
                                            }).addTo(map);
                                            circleLayers.push(circle);
                                        }
                                    }

                                    if (coordinates.length > 0) {
                                        var bounds = L.latLngBounds(coordinates);
                                        map.fitBounds(bounds);
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

                                function copyToClipboard(value) {
                                    var tempInput = document.createElement("textarea");
                                    tempInput.style.position = "absolute";
                                    tempInput.style.left = "-9999px";
                                    tempInput.value = value;
                                    document.body.appendChild(tempInput);
                                    tempInput.select();

                                    try {
                                        var successful = document.execCommand('copy');
                                        alert(successful ? 'Copied the text: ' + value : 'Unable to copy text');
                                    } catch (err) {
                                        console.error('Error copying text: ', err);
                                        alert('Error copying text: ' + err);
                                    } finally {
                                        document.body.removeChild(tempInput);
                                    }
                                }

                                // Fungsi untuk mencetak peta
                                function printMap() {
                                    var mapContainer = document.getElementById('map');
                                    var printWindow = window.open('', '', 'width=800, height=600');
                                    printWindow.document.write('<html><head><title>Print Result Map</title>');
                                    printWindow.document.write('<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />');
                                    printWindow.document.write('<script src="https://unpkg.com/leaflet/dist/leaflet.js"></' + 'script>');
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

                                document.getElementById('addCircleButton').addEventListener('click', function() {
                                    if (circleCoordinateCount < maxCoordinates) {
                                        circleCoordinateCount++;
                                        var circleInputs = document.getElementById('circleInputs');
                                        var div = document.createElement('div');
                                        div.innerHTML = '<label>Latitude Circle ' + circleCoordinateCount + ':</label>' +
                                            '<input type="text" id="circleLatitude' + circleCoordinateCount + '" class="form-control">' +
                                            '<label>Longitude Circle ' + circleCoordinateCount + ':</label>' +
                                            '<input type="text" id="circleLongitude' + circleCoordinateCount + '" class="form-control">' +
                                            '<label>Radius Circle ' + circleCoordinateCount + ' (meters):</label>' +
                                            '<input type="number" id="circleRadius' + circleCoordinateCount + '" class="form-control">' +
                                            '<label>Warna Circle ' + circleCoordinateCount + ':</label>' +
                                            '<select id="circleColor' + circleCoordinateCount + '" class="form-control">' +
                                            '<option value="red">Red</option>' +
                                            '<option value="green">Green</option>' +
                                            '<option value="blue">Blue</option>' +
                                            '<option value="yellow">Yellow</option>' +
                                            '<option value="purple">Purple</option>' +
                                            '<option value="orange">Orange</option>' +
                                            '<option value="white">White</option>' +
                                            '</select>';
                                        circleInputs.appendChild(div);
                                    }
                                });

                                document.getElementById('searchCircleButton').addEventListener('click', function() {
                                    searchCircles();
                                });

                                document.getElementById('resetCircleButton').addEventListener('click', function() {
                                    circleLayers.forEach(function(layer) {
                                        map.removeLayer(layer);
                                    });
                                    circleLayers = [];
                                    circleCoordinateCount = 1; // Reset to first circle
                                    document.getElementById('circleInputs').innerHTML = `
                                        <div>
                                            <label>Latitude Circle 1:</label>
                                            <input type="text" id="circleLatitude1" class="form-control">
                                            <label>Longitude Circle 1:</label>
                                            <input type="text" id="circleLongitude1" class="form-control">
                                            <label>Radius Circle 1 (meters):</label>
                                            <input type="number" id="circleRadius1" class="form-control">
                                            <label>Warna Circle 1:</label>
                                            <select id="circleColor1" class="form-control">
                                                <option value="red">Red</option>
                                                <option value="green">Green</option>
                                                <option value="blue">Blue</option>
                                                <option value="yellow">Yellow</option>
                                                <option value="purple">Purple</option>
                                                <option value="orange">Orange</option>
                                                <option value="white">White</option>
                                            </select>
                                        </div>`;
                                });

                                document.getElementById('getCoordinateButton').addEventListener('click', function() {
                                    if (draggableMarker) {
                                        var position = draggableMarker.getLatLng();
                                        document.getElementById('dragLatitude').value = position.lat.toFixed(6);
                                        document.getElementById('dragLongitude').value = position.lng.toFixed(6);
                                    }
                                });

                                document.getElementById('copyLatitude').addEventListener('click', function() {
                                    copyToClipboard(document.getElementById('dragLatitude').value);
                                });

                                document.getElementById('copyLongitude').addEventListener('click', function() {
                                    copyToClipboard(document.getElementById('dragLongitude').value);
                                });

                                document.getElementById('resetMarkerButton').addEventListener('click', function() {
                                    if (draggableMarker) {
                                        map.removeLayer(draggableMarker);
                                        draggableMarker = null;
                                    }
                                    document.getElementById('dragLatitude').value = '';
                                    document.getElementById('dragLongitude').value = '';
                                });

                                map.on('click', function(e) {
                                    addDraggableMarker(e.latlng);
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>