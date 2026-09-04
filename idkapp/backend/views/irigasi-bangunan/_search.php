<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\IrigasiBangunanSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="irigasi-bangunan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nomeklatur') ?>

    <?= $form->field($model, 'kodeDesa') ?>

    <?= $form->field($model, 'luasIrigasi') ?>

    <?= $form->field($model, 'bgnUtamaStatus') ?>

    <?php // echo $form->field($model, 'bgnUtamaKondisi') ?>

    <?php // echo $form->field($model, 'bgnPengaturPengukurStatus') ?>

    <?php // echo $form->field($model, 'bgnPengaturPengukurKondisi') ?>

    <?php // echo $form->field($model, 'bgnPembawaStatus') ?>

    <?php // echo $form->field($model, 'bgnPembawaKondisi') ?>

    <?php // echo $form->field($model, 'bgnLindungStatus') ?>

    <?php // echo $form->field($model, 'bgnLindungKondisi') ?>

    <?php // echo $form->field($model, 'bgnPelengkapStatus') ?>

    <?php // echo $form->field($model, 'bgnPelengkapKondisi') ?>

    <?php // echo $form->field($model, 'saranaStatus') ?>

    <?php // echo $form->field($model, 'saranaKondisi') ?>

    <?php // echo $form->field($model, 'rataStatus') ?>

    <?php // echo $form->field($model, 'rataKondisi') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'kodeTahun') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
