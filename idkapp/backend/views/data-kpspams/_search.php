<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\DataKpspamsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="data-kpspams-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'provinsi') ?>

    <?= $form->field($model, 'kabupaten') ?>

    <?= $form->field($model, 'kodeKecamatan') ?>

    <?= $form->field($model, 'kodeDesa') ?>

    <?php // echo $form->field($model, 'namaKades') ?>

    <?php // echo $form->field($model, 'noKades') ?>

    <?php // echo $form->field($model, 'namaKpspams') ?>

    <?php // echo $form->field($model, 'noKpspams') ?>

    <?php // echo $form->field($model, 'kodeTahun') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
