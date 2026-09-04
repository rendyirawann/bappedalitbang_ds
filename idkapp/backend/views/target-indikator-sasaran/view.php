<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\TargetIndikatorSasaran $model */

$this->title = $model->indikator_id;
$this->params['breadcrumbs'][] = ['label' => 'Target Indikator Sasarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="target-indikator-sasaran-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'indikator_id' => $model->indikator_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'indikator_id' => $model->indikator_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'indikator_id',
            'cascadingrenstrasasaran_id',
            'refsasaranrenstra_id',
            'refskpd_id',
            'tahun_id',
            'target',
            'target_rkt_p',
            'sebab_rkt_p:ntext',
            'target_pk',
            'sebab_pk:ntext',
            'target_pk_p',
            'sebab_pk_p:ntext',
            'realisasi',
            'capaian',
            'keterangan:ntext',
            'analisis:ntext',
            'analisis_date',
            'analisis_usr',
            'test',
        ],
    ]) ?>

</div>
