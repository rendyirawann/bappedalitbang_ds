<?php

use coderius\lightbox2\Lightbox2;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\DataIpald[] $dataIpald */
/** @var backend\models\IpaldDokumen[] $ipaldDokumens */

$this->title = 'View Data IPALD';
$this->params['breadcrumbs'][] = ['label' => 'Data IPALD', 'url' => ['index']];
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
                            <li class="breadcrumb-item"><a href="<?= Url::to(['/data-ipald/index']) ?>">Data IPALD</a></li>
                            <li class="breadcrumb-item" aria-current="page">View Data IPALD</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">View Data IPALD</h2>
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
                        <h1>View Data IPALD</h1>
                    </div>

                    <div id="map" style="height: 600px; margin-top: 20px;"></div>

<div class="leaflet-control leaflet-control-custom">
    <button id="toggleListButton" class="btn btn-primary">Show/Hide List</button>
    <div id="markerList" style="display: none; max-height: 300px; overflow-y: auto;"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var markers = <?= $markers ?>;

        // Inisialisasi tile layer dari OpenStreetMap
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        });

        // Inisialisasi peta dengan tile layer OpenStreetMap
        var map = L.map('map', {
            center: [-2.5, 117],
            zoom: 5,
            layers: [osm]
        });

        // Fungsi untuk menampilkan marker di peta
        markers.forEach(function (marker) {
            var popupContent = '<p><strong>Fasilitas:</strong> ' + marker.fasilitas + '</p>';
            var popup = L.popup().setContent(popupContent);

            var newMarker = L.marker([marker.latitude, marker.longitude])
                .bindPopup(popup)
                .addTo(map);

            // Tambahkan marker ke kontrol daftar
            var listItem = document.createElement('div');
            listItem.innerHTML = '<a href="#" class="list-item" data-lat="' + marker.latitude + '" data-lng="' + marker.longitude + '">' + marker.fasilitas + '</a>';
            document.getElementById('markerList').appendChild(listItem);

            // Event listener untuk memfokuskan peta pada marker yang dipilih dari daftar
            listItem.addEventListener('click', function (e) {
                e.preventDefault();
                var lat = parseFloat(this.getAttribute('data-lat'));
                var lng = parseFloat(this.getAttribute('data-lng'));
                map.setView([lat, lng], 15);
                newMarker.openPopup();
            });
        });

        // Fungsi untuk menampilkan atau menyembunyikan kontrol daftar
        var toggleListButton = document.getElementById('toggleListButton');
        toggleListButton.addEventListener('click', function () {
            var listContainer = document.querySelector('.leaflet-control-custom');
            var markerList = document.getElementById('markerList');
            if (markerList.style.display === 'none' || markerList.style.display === '') {
                markerList.style.display = 'block';
            } else {
                markerList.style.display = 'none';
            }
        });
    });
</script>
                </div>
            </div>
        </div>
    </div>
</div>
