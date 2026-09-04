<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data IPALD';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data IPALD', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="data-ipald-view">

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
                          'label' => 'Fasilitas',
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
                          'label' => 'Alamat',
                      ],
                      [
                          'attribute' => 'tahunPembangunan',
                          'label' => 'Tahun Pembangunan',
                      ],
                      [
                          'attribute' => 'tahunRehabilitasi',
                          'label' => 'Tahun Rehabilitasi',
                      ],
                      [
                          'attribute' => 'kapasitasDesain',
                          'label' => 'Kapasitas Desain SR',
                      ],
                      [
                          'attribute' => 'kapasitasPakai',
                          'label' => 'Kapasitas Pakai SR',
                      ],
                      [
                          'attribute' => 'sistem',
                          'format' => 'ntext',
                          'label' => 'Sistem yang digunakan',
                      ],
                      [
                          'attribute' => 'kondisi',
                          'label' => 'Kondisi Bangunan',
                      ],
                      [
                          'attribute' => 'kodePengelola',
                          'label' => 'Pengelola (Dinas/UPTD/Masyarakat)',
                      ],
                      [
                          'attribute' => 'cekEffluent',
                          'label' => 'Pengecekan Effluent',
                      ],
                      [
                          'attribute' => 'namaLembaga',
                          'label' => 'Nama Lembaga/Kelompok dan tahun pendirian',
                      ],
                      [
                          'attribute' => 'bentukLembaga',
                          'label' => 'Bentuk lembaga/Kelompok dan dasar pembentukan',
                      ],
                      [
                          'attribute' => 'jumlahAnggota',
                          'label' => 'Jumlah anggota/Pengurus (Orang)',
                      ],
                      [
                          'attribute' => 'kodeBidang',
                          'label' => 'Bidang yang kelola',
                      ],
                      [
                          'attribute' => 'kodeDana',
                          'label' => 'Sumber dana operasional',
                      ],
                      [
                          'attribute' => 'kodeAset',
                          'label' => 'Aset barang dan sumber pengadaan',
                      ],
                      [
                          'attribute' => 'kodeStatus',
                          'label' => 'Status Aset',
                      ],
                      [
                          'attribute' => 'latitude',
                          'label' => 'Koordinat Sarpras (latitude)',
                      ],
                      [
                          'attribute' => 'longitude',
                          'label' => 'Koordinat Sarpras (longitude)',
                      ],
                  ],
              ]) ?>

</div>
