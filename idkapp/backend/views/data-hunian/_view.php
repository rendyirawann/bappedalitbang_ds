<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Hunian';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Hunian', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-hunian-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'namaPemohon',
            'kodeDesa',
            'kodeKecamatan',
            'lokasiBangunan',
            'noRegPbg',
            'jenisBangunan',
            'jlhUnit',
            'retribusi',
            'tanggal',
            'kodeTahun',
        ],
    ]) ?>


</div>