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
                            <li class="breadcrumb-item" aria-current="page">Map GIS Control - Marker</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Map GIS Control - Marker</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1>Map GIS Control - Marker</h1>

                        <h3>Add Marker</h3>
                        <form id="markerForm">
                            <div id="markerInputs">
                                <div>
                                    <label>Latitude Marker 1:</label>
                                    <input type="text" id="markerLatitude1" class="form-control">
                                    <label>Longitude Marker 1:</label>
                                    <input type="text" id="markerLongitude1" class="form-control">
                                </div>
                            </div>
                            <button type="button" id="addMarkerButton" class="btn btn-primary mt-2"><i data-feather="plus-circle"></i> Add Marker</button>
                            <button type="button" id="searchMarkerButton" class="btn btn-success mt-2"><i data-feather="search"></i> Find Marker</button>
                            <button type="button" id="resetMarkerButton" class="btn btn-danger mt-2"><i data-feather="refresh-ccw"></i> Reset Marker</button>
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
                            <button type="button" id="resetCoordinateButton" class="btn btn-danger mt-2"><i data-feather="refresh-ccw"></i> Reset Coordinate</button>
                        </form>
                        <button type="button" id="printMapButton" class="btn btn-secondary mt-2"><i data-feather="printer"></i> Print Map</button>

                        <div id="map" style="height: 500px; margin-top: 20px;"></div>

                        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                var maxMarkerCoordinates = 6;
                                var markerCoordinateCount = 1;
                                var draggableMarker;
                                var markerLayers = [];

                                // Inisialisasi peta
                                var map = L.map('map').setView([3.5481174369442385, 98.86602983920459], 12); // Koordinat Jakarta

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
                                        document.execCommand('copy');
                                        alert('Copied: ' + value);
                                    } catch (err) {
                                        console.error('Copy error: ', err);
                                    } finally {
                                        document.body.removeChild(tempInput);
                                    }
                                }

                                // // Fungsi untuk mencetak elemen tertentu
                                // function printElement(element) {
                                //     var originalContents = document.body.innerHTML;
                                //     var printContents = document.getElementById(element).innerHTML;
                                //     document.body.innerHTML = printContents;
                                //     window.print();
                                //     document.body.innerHTML = originalContents;
                                // }

                                // // Event listener untuk tombol print
                                // document.getElementById('printMapButton').addEventListener('click', function() {
                                //     printElement('map');
                                // });

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

                                document.getElementById('addMarkerButton').addEventListener('click', function() {
                                    if (markerCoordinateCount < maxMarkerCoordinates) {
                                        markerCoordinateCount++;
                                        var markerInputs = document.getElementById('markerInputs');
                                        var div = document.createElement('div');
                                        div.innerHTML = '<label>Latitude Marker ' + markerCoordinateCount + ':</label>' +
                                            '<input type="text" id="markerLatitude' + markerCoordinateCount + '" class="form-control">' +
                                            '<label>Longitude Marker ' + markerCoordinateCount + ':</label>' +
                                            '<input type="text" id="markerLongitude' + markerCoordinateCount + '" class="form-control">';
                                        markerInputs.appendChild(div);
                                    }
                                });

                                document.getElementById('searchMarkerButton').addEventListener('click', searchMarkers);

                                document.getElementById('resetMarkerButton').addEventListener('click', function() {
                                    markerCoordinateCount = 1;
                                    document.getElementById('markerInputs').innerHTML = '<div><label>Latitude Marker 1:</label>' +
                                        '<input type="text" id="markerLatitude1" class="form-control">' +
                                        '<label>Longitude Marker 1:</label>' +
                                        '<input type="text" id="markerLongitude1" class="form-control"></div>';
                                    markerLayers.forEach(function(layer) {
                                        map.removeLayer(layer);
                                    });
                                    markerLayers = [];
                                });

                                document.getElementById('getCoordinateButton').addEventListener('click', function() {
                                    if (draggableMarker) {
                                        map.removeLayer(draggableMarker);
                                    }

                                    map.on('click', function(event) {
                                        var latlng = event.latlng;
                                        addDraggableMarker(latlng);
                                        document.getElementById('dragLatitude').value = latlng.lat.toFixed(6);
                                        document.getElementById('dragLongitude').value = latlng.lng.toFixed(6);
                                    });
                                });

                                document.getElementById('resetCoordinateButton').addEventListener('click', function() {
                                    if (draggableMarker) {
                                        map.removeLayer(draggableMarker);
                                        draggableMarker = null;
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