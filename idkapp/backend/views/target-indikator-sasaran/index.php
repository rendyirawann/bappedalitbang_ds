<?php

use backend\models\TargetIndikatorSasaran;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\TargetIndikatorSasaranSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Target Indikator Sasarans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="target-indikator-sasaran-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Target Indikator Sasaran', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'indikator_id',
            'cascadingrenstrasasaran_id',
            'refsasaranrenstra_id',
            'refskpd_id',
            'tahun_id',
            //'target',
            //'target_rkt_p',
            //'sebab_rkt_p:ntext',
            //'target_pk',
            //'sebab_pk:ntext',
            //'target_pk_p',
            //'sebab_pk_p:ntext',
            //'realisasi',
            //'capaian',
            //'keterangan:ntext',
            //'analisis:ntext',
            //'analisis_date',
            //'analisis_usr',
            //'test',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TargetIndikatorSasaran $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'indikator_id' => $model->indikator_id]);
                 }
            ],
        ],
    ]); ?>


</div>
