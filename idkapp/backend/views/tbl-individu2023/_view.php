<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Individu 2023';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Individu 2023', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-individu2023-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'no',
            'kode_kegiatan:ntext',
            'kode_sub:ntext',
            'kode_rekening:ntext',
            'namaKegiatan:ntext',
            'kecamatan:ntext',
            'satuan:ntext',
            'jumlah',
            'hargaSatuan',
            'keterangan:ntext',
        ],
    ]) ?>


</div>
