<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Kegiatan Jembatan';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Kegiatan Jembatan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-jembatan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'namaPekerjaan',
                        'format' => 'ntext',
                        'label' => 'Nama Pekerjaan',
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
                        'attribute' => 'penyedia',
                        'label' => 'Penyedia',
                    ],
                    [
                        'attribute' => 'nilaiPagu',
                        'label' => 'Nilai Pagu (Rp.)',
                    ],
                    [
                        'attribute' => 'nilaiKontrak',
                        'label' => 'Nilai Kontrak (Rp.)',
                    ],
                    [
                        'attribute' => 'nilaiAddendum',
                        'label' => 'Nilai Kontrak Addendum (Rp.)',
                    ],
                    [
                        'attribute' => 'nomorSpmk',
                        'label' => 'Nomor dan Tanggal SPMK',
                    ],
                    [
                        'attribute' => 'nomorKontrak',
                        'label' => 'Nomor dan Tanggal Kontrak',
                    ],
                    [
                        'attribute' => 'nomorAddendum',
                        'label' => 'Nomor dan Tanggal Kontrak Addendum',
                    ],
                    [
                        'attribute' => 'nomorPho',
                        'label' => 'PHO Nomor/Tanggal',
                    ],
                    [
                        'attribute' => 'realisasiPanjang',
                        'label' => 'Realisasi Meter Panjang',
                    ],
                    [
                        'attribute' => 'realisasiLebar',
                        'label' => 'Realisasi Meter Lebar',
                    ],
                    [
                        'attribute' => 'keterangan',
                        'label' => 'Keterangan',
                    ],
                    [
                        'attribute' => 'tahun',
                        'label' => 'Tahun',
                    ],
                ],
            ]) ?>


</div>
