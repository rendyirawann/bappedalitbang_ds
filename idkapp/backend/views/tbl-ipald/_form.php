<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\TblIpald $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-ipald-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no')->textInput() ?>

    <?= $form->field($model, 'enumerator')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fasilitas')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'wilayah')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'thn_pembangunan')->textInput() ?>

    <?= $form->field($model, 'thn_rehabilitasi')->textInput() ?>

    <?= $form->field($model, 'kapasitas_desain')->textInput() ?>

    <?= $form->field($model, 'kapasitas_pakai')->textInput() ?>

    <?= $form->field($model, 'sistem')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kondisi')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pengelola')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pengecekan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nama_lembaga')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'bentuk_lembaga')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'jlh_anggota')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kel_bidang')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'operasional')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'asset')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'latitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
