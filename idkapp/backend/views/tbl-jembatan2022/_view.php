<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Jembatan 2022';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Jembatan 2022', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-jembatan2022-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'no',
            'namaPekerjaan:ntext',
            'realisasi_meter',
            'keterangan:ntext',
        ],
    ]) ?>


</div>
