<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\TblIndividu2021Search $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-individu2021-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'no') ?>

    <?= $form->field($model, 'namaKegiatan') ?>

    <?= $form->field($model, 'desa') ?>

    <?= $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'uraian') ?>

    <?php // echo $form->field($model, 'target') ?>

    <?php // echo $form->field($model, 'capaian') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
