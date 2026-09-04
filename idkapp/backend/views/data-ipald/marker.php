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

                    <!-- Button untuk show/hide kontrol daftar -->
                    <button class="btn btn-info" id="toggleListButton" style="margin: 10px;">Show/Hide List</button>

                    <!-- Map Container -->
                    <div id="map" style="height: 500px; margin-top: 20px;"></div>

                    <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        // Inisialisasi tile layer dari OpenStreetMap dan OpenStreetMap HOT
                        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap contributors'
                        });

                        var osmHOT = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap contributors, Tiles style by Humanitarian OpenStreetMap Team hosted by OpenStreetMap France'
                        });

                        // Inisialisasi tile layer dari Mapbox
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
                        var map = L.map('map', {
                            center: [<?= $dataIpald[0]->latitude ?>, <?= $dataIpald[0]->longitude ?>],
                            zoom: 13,
                            layers: [osm]
                        });

                        // Membuat ikon dengan warna merah
                        var redIcon = L.icon({
                            iconUrl: '<?= Yii::getAlias('@web/lightapp/assets/images/red-marker.png') ?>',
                            iconSize: [24, 35], // Ukuran ikon
                            iconAnchor: [12, 41], // Posisi ikon yang menunjuk ke titik
                            popupAnchor: [1, -34] // Posisi popup relatif terhadap ikon
                        });

                        // Mendefinisikan ikon default (warna biru)
                        var blueIcon = L.icon({
                            iconUrl: '<?= Yii::getAlias('@web/lightapp/assets/images/blue-marker.png') ?>',
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

                        // Menambahkan semua marker ke peta
                        var markers = [];
                        <?php foreach ($dataIpald as $data): ?>
                            var marker = L.marker([<?= $data->latitude ?>, <?= $data->longitude ?>], {icon: blueIcon}).addTo(map);

                            var popupContent = '<p>Lokasi: <?= Html::encode($data->fasilitas) ?></p><br>' +
    '<p>Koordinat: <?= Html::encode($data->longitude) ?> (long), <?= Html::encode($data->latitude) ?> (lat)</p>' +
    '<p><a href="https://www.google.com/maps?q=<?= Html::encode($data->latitude) ?>,<?= Html::encode($data->longitude) ?>" target="_blank">Lihat di Google Maps</a></p>';

<?php foreach ($ipaldDokumens as $ipaldDokumen): ?>
    if (<?= $data->id ?> == <?= $ipaldDokumen->kodeDataIpald ?>) {
        popupContent += '<div><img src="<?= Yii::getAlias('@web/dokumen/data_ipald_image/') . $ipaldDokumen->file ?>" style="width:300px;height:150px;margin-bottom:10px;"></div>';
    }
<?php endforeach; ?>


                            marker.bindPopup(popupContent);
                            markers.push({id: <?= $data->id ?>, marker: marker});
                        <?php endforeach; ?>

                        // Fungsi untuk memindahkan peta ke lokasi tertentu dan menampilkan popup
                        window.flyToLocation = function (id) {
                            // Reset warna semua marker
                            markers.forEach(function (m) {
                                m.marker.setIcon(blueIcon); // Ganti dengan ikon default
                            });

                            // Temukan marker yang sesuai berdasarkan ID
                            var selectedMarker = markers.find(m => m.id === id).marker;

                            // Ubah warna marker menjadi merah
                            selectedMarker.setIcon(redIcon);

                            map.setView(selectedMarker.getLatLng(), 13);
                            selectedMarker.openPopup();

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
                                var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom', L.DomUtil.get('listContainer'));

                                container.style.backgroundColor = 'white';
                                container.style.padding = '10px';
                                container.style.width = '600px'; // Lebar kontrol diperlebar
                                container.style.maxWidth = '1000px'; // Maksimal lebar kontrol
                                container.style.maxHeight = '200px';
                                container.style.overflowY = 'auto';
                                container.style.display = 'none'; // Awalnya disembunyikan

                                //
                                // Membuat daftar marker
                                var list = document.createElement('ul');
                                list.style.listStyle = 'none'; // Menghapus bullet points
                                list.style.padding = '0';
                                list.style.margin = '0';
                                <?php foreach ($dataIpald as $data): ?>
                                    var listItem = document.createElement('li');
                                    listItem.innerHTML = '<a href="#" onclick="flyToLocation(<?= $data->id ?>)"><?= Html::encode($data->fasilitas) ?></a>';
                                    listItem.style.padding = '5px 0'; // Memberikan sedikit padding untuk setiap item
                                    listItem.style.whiteSpace = 'nowrap';
                                    listItem.style.overflow = 'hidden'; // Hide overflow text
                                    listItem.style.textOverflow = 'ellipsis'; // Add ellipsis for overflow text
                                    listItem.addEventListener('click', function(event) {
                                        event.preventDefault();
                                        flyToLocation(<?= $data->id ?>); // Panggil fungsi flyToLocation dengan id marker yang sesuai
                                    });
                                    list.appendChild(listItem);
                                <?php endforeach; ?>

                                container.appendChild(list);
                                return container;
                            }
                        });

                        // Menambahkan kontrol custom ke peta
                        var listControl = new customControl();
                        map.addControl(listControl);

                        // Fungsi untuk menampilkan atau menyembunyikan kontrol daftar
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
