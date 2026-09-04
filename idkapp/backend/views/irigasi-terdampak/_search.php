<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\IrigasiTerdampakSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="irigasi-terdampak-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nomeklatur') ?>

    <?= $form->field($model, 'kodeDesa') ?>

    <?= $form->field($model, 'luasIrigasi') ?>

    <?= $form->field($model, 'arealBaik') ?>

    <?php // echo $form->field($model, 'arealRusakRingan') ?>

    <?php // echo $form->field($model, 'arealRusakSedang') ?>

    <?php // echo $form->field($model, 'arealRusakBerat') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'kodeTahun') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
