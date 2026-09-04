<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Bank Sampah';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Bank Sampah', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-sampah-view">

    <h1><?= Html::encode($this->title) ?></h1>

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



</div>
