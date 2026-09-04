<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\TblJembatan2023 $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-jembatan2023-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no')->textInput() ?>

    <?= $form->field($model, 'namaPekerjaan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'penyedia')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nilaiPagu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nilaiKontrak')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nilaiKontrakAdd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'noSpmk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'noKontrak')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'noKontrakAdd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'noPho')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'realisasi_meter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
