<?php

use coderius\lightbox2\Lightbox2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\DataSampah $model */

$this->title = 'View Data Bank Sampah - ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Sampahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
echo Lightbox2::widget([
    'clientOptions' => [
        'resizeDuration' => 200,
        'wrapAround' => true,
    ],
]);

$this->registerJs("
    $('#createModal').on('show.bs.modal', function (event) {
        var modal = $(this);
        $.ajax({
            url: '" . Url::to(['data-sampah/create']) . "',
            type: 'GET',
            success: function(data) {
                modal.find('#modalFormContent').html(data);
            }
        });
    });
");
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
                            <li class="breadcrumb-item"><a href="<?= Url::to(['/data-sampah/index']) ?>">Data Bank Sampah</a></li>
                            <li class="breadcrumb-item" aria-current="page">View Data Bank Sampah</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">View Data Bank Sampah</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->


        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ form-element ] start -->
            <div class="col-lg-12">
                <!-- Basic Inputs -->
                <div class="card">
                    <div class="card-body">
                        <h1>View Data Bank Sampah - <?= Html::encode($model->id) ?></h1>

                        <p>
                            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                            <?= Html::a('Tambah Gambar', ['sampah-dokumen/create', 'kodeDataSampah' => $model->id], ['class' => 'btn btn-success']) ?>
                            <?= Html::button('<i class="fa fa-plus"></i>', [
                                'class' => 'btn btn-success',
                                'data-bs-toggle' => 'modal',
                                'data-bs-target' => '#createModal',
                            ]) ?>
                        </p>


                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'id',
                                [
                                    'attribute' => 'enumerator',
                                    'format' => 'ntext',
                                    'label' => 'Enumerator',
                                ],
                                [
                                    'attribute' => 'fasilitas',
                                    'format' => 'ntext',
                                    'label' => 'Fasilitas yang Dikelola',
                                ],
                                [
                                    'attribute' => 'kodeKecamatan',
                                    'label' => 'Kecamatan',
                                ],
                                [
                                    'attribute' => 'kodeDesa',
                                    'label' => 'Desa',
                                ],
                                [
                                    'attribute' => 'alamat',
                                    'label' => 'Lokasi (Alamat)',
                                ],
                                [
                                    'attribute' => 'kondisi',
                                    'label' => 'Kondisi Pengelolaan (Beroperasi/Tidak Beroperasi)',
                                ],
                                [
                                    'attribute' => 'tahunPembangunan',
                                    'label' => 'Tahun Pembangunan',
                                ],
                                [
                                    'attribute' => 'tahunOptimalisasi',
                                    'label' => 'Tahun Optimalisasi (Jika Dilakukan)',
                                ],
                                [
                                    'attribute' => 'kegiatanPengurangan',
                                    'label' => 'Kegiatan Pengurangan (Pengomposan/Daur Ulang)',
                                ],
                                [
                                    'attribute' => 'jlhSampahMasuk',
                                    'label' => 'Jumlah Sampah Masuk (Ton/Hari)',
                                ],
                                [
                                    'attribute' => 'jlhSampahKompos',
                                    'label' => 'Jumlah Sampah Masuk yang Terolah menjadi Bahan Baku/Kompos (Ton/Hari)',
                                ],
                                [
                                    'attribute' => 'jlhSampahResidu',
                                    'label' => 'Jumlah Sampah Residu yang Dibawa ke TPA (Ton/Hari)',
                                ],
                                [
                                    'attribute' => 'kodePengelola',
                                    'label' => 'Pengelola (KSM/Dinas/UPTD)',
                                ],
                                [
                                    'attribute' => 'namaLembaga',
                                    'label' => 'Nama Lembaga/Kelompok dan Tahun Pendirian',
                                ],
                                [
                                    'attribute' => 'bentukLembaga',
                                    'label' => 'Bentuk Lembaga/Kelompok dan Dasar Pembentukan',
                                ],
                                [
                                    'attribute' => 'jlhAnggota',
                                    'label' => 'Jumlah Anggota/Pengurus (Orang)',
                                ],
                                [
                                    'attribute' => 'kodeBidang',
                                    'label' => 'Bidang yang Kelola',
                                ],
                                [
                                    'attribute' => 'wilayah',
                                    'label' => 'Cakupan Wilayah',
                                ],
                                [
                                    'attribute' => 'kodeDana',
                                    'label' => 'Sumberdana Operasional',
                                ],
                                [
                                    'attribute' => 'kodeAset',
                                    'label' => 'Aset Barang dan Sumber Pengadaan',
                                ],
                                [
                                    'attribute' => 'status',
                                    'label' => 'Status/Keterangan (Beroperasi / Tidak Beroperasi)',
                                ],
                                [
                                    'attribute' => 'latitude',
                                    'label' => 'Koordinat Lokasi Sarpras (Latitude)',
                                ],
                                [
                                    'attribute' => 'longitude',
                                    'label' => 'Koordinat Lokasi Sarpras (Longitude)',
                                ],
                            ],
                        ]) ?>

                        <?php
                        // Mengambil semua BeritaAlt yang memiliki berita_id sesuai dengan id berita saat ini
                        $sampahDokumens = \backend\models\SampahDokumen::find()
                            ->where(['kodeDataSampah' => $model->id])
                            ->all();
                        ?>

                        <?php if (!empty($sampahDokumens)) : ?>
                            <h2>Gambar Tambahan</h2>
                            <div class="row">
                                <?php foreach ($sampahDokumens as $sampahDokumen) : ?>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        <div class="thumbnail">
                                            <?= Html::a(
                                                Html::img('@web/dokumen/data_sampah_image/' . $sampahDokumen->file, [
                                                    'style' => 'width: 100%; height: 200px; object-fit: cover;'
                                                ]),
                                                '@web/dokumen/data_sampah_image/' . $sampahDokumen->file,
                                                ['data-lightbox' => 'sampah-dokumen', 'data-title' => $model->fasilitas]
                                            )
                                            ?>
                                            <?= Html::a(
                                                '<i class="fa fa-download"></i>',
                                                ['sampah-dokumen/download', 'id' => $sampahDokumen->id],
                                                [
                                                    'class' => 'btn btn-success btn-sm mr-2',
                                                    'title' => 'Download',
                                                ]
                                            ) ?>
                                            <?= Html::a('<i class="fa fa-trash"></i>', ['sampah-dokumen/delete', 'id' => $sampahDokumen->id], [
                                                'class' => 'btn btn-danger btn-sm',
                                                'title' => 'Delete',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this file?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>

                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <p>Tidak ada Gambar Tambahan untuk Marker ini</p>
                        <?php endif; ?>
                        <?php
                        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
                        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
                        ?>

                            <?= Html::a('Tambah Gambar', ['sampah-dokumen/create', 'kodeDataSampah' => $model->id], ['class' => 'btn btn-success mt-3']) ?>
                        <?php } ?>

                        <!-- Map Container -->
                        <!-- Map Container -->
                        <div id="map" style="height: 500px; margin-top: 20px;"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
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
                                    center: [<?= $model->latitude ?>, <?= $model->longitude ?>],
                                    zoom: 13,
                                    layers: [osm]
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

                                // Menambahkan marker ke peta
                                var marker = L.marker([<?= $model->latitude ?>, <?= $model->longitude ?>]).addTo(map);



                                // Popup content with images
                                var popupContent = '<p>Lokasi: <?= Html::encode($model->fasilitas) ?></p> <br> <p>Koordinat: <?= Html::encode($model->longitude) ?>(long), <?= Html::encode($model->latitude) ?>(lat)</p>';

                                <?php foreach ($sampahDokumens as $sampahDokumen) : ?>
                                    popupContent += '<div><img src="<?= Yii::getAlias('@web/dokumen/data_sampah_image/') . $sampahDokumen->file ?>" style="width:300px;height:150px;margin-bottom:10px;"></div>';
                                <?php endforeach; ?>

                                marker.bindPopup(popupContent);
                            });
                        </script>


                    </div>
                </div>

            </div>
            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Tambah Data Bank Sampah</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- The form will be loaded here -->
                            <div id="modalFormContent">
                                <!-- AJAX-loaded content will be injected here -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->

            <!-- [ form-element ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>