<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\TargetIndikatorSasaranSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="target-indikator-sasaran-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'indikator_id') ?>

    <?= $form->field($model, 'cascadingrenstrasasaran_id') ?>

    <?= $form->field($model, 'refsasaranrenstra_id') ?>

    <?= $form->field($model, 'refskpd_id') ?>

    <?= $form->field($model, 'tahun_id') ?>

    <?php // echo $form->field($model, 'target') ?>

    <?php // echo $form->field($model, 'target_rkt_p') ?>

    <?php // echo $form->field($model, 'sebab_rkt_p') ?>

    <?php // echo $form->field($model, 'target_pk') ?>

    <?php // echo $form->field($model, 'sebab_pk') ?>

    <?php // echo $form->field($model, 'target_pk_p') ?>

    <?php // echo $form->field($model, 'sebab_pk_p') ?>

    <?php // echo $form->field($model, 'realisasi') ?>

    <?php // echo $form->field($model, 'capaian') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'analisis') ?>

    <?php // echo $form->field($model, 'analisis_date') ?>

    <?php // echo $form->field($model, 'analisis_usr') ?>

    <?php // echo $form->field($model, 'test') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
