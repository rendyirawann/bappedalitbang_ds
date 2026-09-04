<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Jembatan 2022';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Jembatan 2022', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-jembatan2023-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'no',
            'namaPekerjaan:ntext',
            'penyedia:ntext',
            'nilaiPagu',
            'nilaiKontrak',
            'nilaiKontrakAdd',
            'noSpmk',
            'noKontrak',
            'noKontrakAdd',
            'noPho',
            'realisasi_meter',
            'keterangan',
        ],
    ]) ?>


</div>
