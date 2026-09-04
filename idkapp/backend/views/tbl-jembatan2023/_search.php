<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\TblJembatan2023Search $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-jembatan2023-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'no') ?>

    <?= $form->field($model, 'namaPekerjaan') ?>

    <?= $form->field($model, 'penyedia') ?>

    <?= $form->field($model, 'nilaiPagu') ?>

    <?php // echo $form->field($model, 'nilaiKontrak') ?>

    <?php // echo $form->field($model, 'nilaiKontrakAdd') ?>

    <?php // echo $form->field($model, 'noSpmk') ?>

    <?php // echo $form->field($model, 'noKontrak') ?>

    <?php // echo $form->field($model, 'noKontrakAdd') ?>

    <?php // echo $form->field($model, 'noPho') ?>

    <?php // echo $form->field($model, 'realisasi_meter') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
