<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data KPSPAMS';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data KPSPAMS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="data-kpspams-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'provinsi:ntext',
            'kabupaten:ntext',
            [
                'attribute' => 'kodeKecamatan',
                'label' => 'Nama Kecamatan',
                'value' => function ($model) {
                    return $model->kodeKecamatan0 ? $model->kodeKecamatan0->namaKecamatan : null;
                },
            ],
            [
                'attribute' => 'Nama Desa',
                'value' => function ($model) {
                    return $model->desa ? $model->desa->namaDesa  : null;
                },
            ],
            [
                'label' => 'Kode Desa',
                'value' => function ($model) {
                    return $model->desa ? ' (' . $model->desa->kode . ')' : null;
                },
            ],
            'namaKades:ntext',
            'noKades',
            'namaKpspams:ntext',
            'noKpspams',
            'kodeTahun',
        ],
    ]) ?>

</div>