<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Septic Tank Individu';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Septic Tank Individu', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-individu-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'koderef_kegiatan',
                'label' => 'Kode Kegiatan',
            ],
            [
                'attribute' => 'ref_kegiatan',
                'label' => 'Nama Ref Kegiatan',
            ],
            [
                'attribute' => 'koderef_subkegiatan',
                'label' => 'Kode Sub Kegiatan',
            ],
            [
                'attribute' => 'ref_subkegiatan',
                'label' => 'Nama Sub Kegiatan',
            ],
            [
                'attribute' => 'kodeRekening',
                'label' => 'Kode Rekening',
            ],
            [
                'attribute' => 'namaKegiatan',
                'format' => 'ntext',
                'label' => 'Nama Kegiatan',
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
                'attribute' => 'satuan',
                'label' => 'Satuan (Unit)',
            ],
            [
                'attribute' => 'jumlah',
                'label' => 'Jumlah',
            ],
            [
                'attribute' => 'harga',
                'label' => 'Harga Satuan (Rp.)',
            ],
            [
                'attribute' => 'kodeDana',
                'label' => 'Keterangan Sumber Dana',
            ],
            [
                'attribute' => 'kodeTahun',
                'label' => 'Tahun',
            ],
        ],
    ]) ?>


</div>