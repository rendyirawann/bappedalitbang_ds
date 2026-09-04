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
                            <li class="breadcrumb-item" aria-current="page">Map GIS Control</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Map GIS Control</h2>
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
                        <h1>Map GIS Control</h1>

                        <!-- Form Input Marker -->
                        <h3>Tambah Marker</h3>
                        <form id="markerForm">
                            <div id="markerInputs">
                                <div>
                                    <label>Latitude Marker 1:</label>
                                    <input type="text" id="markerLatitude1" class="form-control">
                                    <label>Longitude Marker 1:</label>
                                    <input type="text" id="markerLongitude1" class="form-control">
                                </div>
                            </div>
                            <button type="button" id="addMarkerButton" class="btn btn-primary">Tambah Marker</button>
                            <button type="button" id="searchMarkerButton" class="btn btn-success">Cari Marker</button>
                        </form>

                        <!-- Form Input Polyline -->
                        <h3>Tambah Polyline</h3>
                        <form id="polylineForm">
                            <div id="polylineInputs">
                                <div>
                                    <label>Latitude Polyline 1:</label>
                                    <input type="text" id="polylineLatitude1" class="form-control">
                                    <label>Longitude Polyline 1:</label>
                                    <input type="text" id="polylineLongitude1" class="form-control">
                                </div>
                            </div>
                            <button type="button" id="addPolylineButton" class="btn btn-primary">Tambah Polyline</button>
                            <button type="button" id="searchPolylineButton" class="btn btn-success">Cari Polyline</button>
                        </form>

                        <!-- Form Input Routing -->
                        <h3>Tambah Routing</h3>
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
                            <button type="button" id="searchRouteButton" class="btn btn-success">Cari Route</button>
                        </form>

                        <!-- Form Input Circle -->
                        <h3>Tambah Circle</h3>
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
                            <button type="button" id="addCircleButton" class="btn btn-primary">Tambah Circle</button>
                            <button type="button" id="searchCircleButton" class="btn btn-success">Cari Circle</button>
                        </form>

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
                            <button type="button" id="getCoordinateButton" class="btn btn-info mt-2">Get Coordinate</button>
                        </form>

                        <!-- Map Container -->
                        <div id="map" style="height: 500px; margin-top: 20px;"></div>

                        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                var maxCoordinates = 6;
                                var markerCoordinateCount = 1;
                                var polylineCoordinateCount = 1;
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
                                var polyline;
                                var routingControl;
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


                                // Fungsi untuk mencari dan menambahkan polyline pada koordinat tertentu
                                function searchPolyline() {
                                    // Hapus polyline sebelumnya jika ada
                                    if (polyline) {
                                        map.removeLayer(polyline);
                                    }

                                    var coordinates = [];

                                    for (var i = 1; i <= polylineCoordinateCount; i++) {
                                        var lat = parseFloat(document.getElementById('polylineLatitude' + i).value);
                                        var lng = parseFloat(document.getElementById('polylineLongitude' + i).value);
                                        if (!isNaN(lat) && !isNaN(lng)) {
                                            coordinates.push([lat, lng]);
                                        }
                                    }

                                    if (coordinates.length > 0) {
                                        polyline = L.polyline(coordinates, {
                                            color: 'red'
                                        }).addTo(map);
                                        map.fitBounds(polyline.getBounds());
                                    }
                                }

                                // Fungsi untuk mencari route antara starting point dan end point
                                function searchRoute() {
                                    // Hapus routingControl sebelumnya jika ada
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

                                // Fungsi untuk mencari dan menambahkan circle pada koordinat tertentu
                                function searchCircles() {
                                    // Hapus semua circle sebelumnya
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

                                // Event listener untuk tombol tambah marker
                                document.getElementById('addMarkerButton').addEventListener('click', function() {
                                    if (markerCoordinateCount < maxCoordinates) {
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

                                // Event listener untuk tombol cari marker
                                document.getElementById('searchMarkerButton').addEventListener('click', function() {
                                    searchMarkers();
                                });

                                // Event listener untuk tombol tambah polyline
                                document.getElementById('addPolylineButton').addEventListener('click', function() {
                                    if (polylineCoordinateCount < maxCoordinates) {
                                        polylineCoordinateCount++;
                                        var polylineInputs = document.getElementById('polylineInputs');
                                        var div = document.createElement('div');
                                        div.innerHTML = '<label>Latitude Polyline ' + polylineCoordinateCount + ':</label>' +
                                            '<input type="text" id="polylineLatitude' + polylineCoordinateCount + '" class="form-control">' +
                                            '<label>Longitude Polyline ' + polylineCoordinateCount + ':</label>' +
                                            '<input type="text" id="polylineLongitude' + polylineCoordinateCount + '" class="form-control">';
                                        polylineInputs.appendChild(div);
                                    }
                                });

                                // Event listener untuk tombol cari polyline
                                document.getElementById('searchPolylineButton').addEventListener('click', function() {
                                    searchPolyline();
                                });

                                // Event listener untuk tombol cari route
                                document.getElementById('searchRouteButton').addEventListener('click', function() {
                                    searchRoute();
                                });

                                // Event listener untuk tombol tambah circle
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

                                // Event listener untuk tombol cari circle
                                document.getElementById('searchCircleButton').addEventListener('click', function() {
                                    searchCircles();
                                });

                                // Event listener untuk tombol "Get Coordinat"
                                document.getElementById('getCoordinateButton').addEventListener('click', function() {
                                    // Hapus marker sebelumnya jika ada
                                    if (draggableMarker) {
                                        map.removeLayer(draggableMarker);
                                    }

                                    // Tambahkan marker yang dapat di-drag pada peta
                                    map.on('click', function(event) {
                                        var latlng = event.latlng;
                                        addDraggableMarker(latlng);

                                        // Update nilai input latitude dan longitude
                                        document.getElementById('dragLatitude').value = latlng.lat.toFixed(6);
                                        document.getElementById('dragLongitude').value = latlng.lng.toFixed(6);
                                    });
                                });

                                // Event listener untuk tombol "Copy Latitude"
                                document.getElementById('copyLatitude').addEventListener('click', function() {
                                    var latitudeValue = document.getElementById('dragLatitude').value;
                                    copyToClipboard(latitudeValue);
                                });

                                // Event listener untuk tombol "Copy Longitude"
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