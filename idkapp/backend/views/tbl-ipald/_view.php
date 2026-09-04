<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data IPALD';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data IPALD', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-ipald-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'no',
            'enumerator:ntext',
            'fasilitas:ntext',
            'wilayah:ntext',
            'thn_pembangunan',
            'thn_rehabilitasi',
            'kapasitas_desain',
            'kapasitas_pakai',
            'sistem:ntext',
            'kondisi:ntext',
            'pengelola:ntext',
            'pengecekan:ntext',
            'nama_lembaga:ntext',
            'bentuk_lembaga:ntext',
            'jlh_anggota:ntext',
            'kel_bidang:ntext',
            'operasional:ntext',
            'asset:ntext',
            'status:ntext',
            'latitude',
            'longitude',
        ],
    ]) ?>


</div>
