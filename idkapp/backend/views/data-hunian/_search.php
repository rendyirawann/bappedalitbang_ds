<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\DataHunianSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="data-hunian-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'namaPemohon') ?>

    <?= $form->field($model, 'kodeDesa') ?>

    <?= $form->field($model, 'kodeKecamatan') ?>

    <?= $form->field($model, 'lokasiBangunan') ?>

    <?php // echo $form->field($model, 'noRegPbg') ?>

    <?php // echo $form->field($model, 'jenisBangunan') ?>

    <?php // echo $form->field($model, 'jlhUnit') ?>

    <?php // echo $form->field($model, 'retribusi') ?>

    <?php // echo $form->field($model, 'tanggal') ?>

    <?php // echo $form->field($model, 'kodeTahun') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
