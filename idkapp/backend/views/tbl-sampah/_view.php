<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Sampah';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Sampah', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-sampah-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'no',
            'enumerator:ntext',
            'fasilitas:ntext',
            'lokasi:ntext',
            'kondisi:ntext',
            'thn_pembangunan',
            'thn_optimalisasi',
            'kegiatan_pengurangan:ntext',
            'jlh_sampah_masuk',
            'jlh_sampah_terolah',
            'jlh_sampah_residu',
            'pengelola:ntext',
            'nama_lembaga:ntext',
            'bentuk_lembaga:ntext',
            'jlh_anggota:ntext',
            'kel_bidang:ntext',
            'wilayah:ntext',
            'operasional:ntext',
            'asset:ntext',
            'status:ntext',
            'latitude',
            'longitude',
        ],
    ]) ?>


</div>
