<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\PegawaiSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pegawai-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'statusAparatur') ?>

    <?= $form->field($model, 'namaLengkap') ?>

    <?= $form->field($model, 'nip') ?>

    <?= $form->field($model, 'eselon') ?>

    <?php // echo $form->field($model, 'kodeBidang') ?>

    <?php // echo $form->field($model, 'kodeTitle') ?>

    <?php // echo $form->field($model, 'no_hp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
