<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\TblIndividu2023 $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-individu2023-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no')->textInput() ?>

    <?= $form->field($model, 'kode_kegiatan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kode_sub')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kode_rekening')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'namaKegiatan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kecamatan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'satuan')->textInput() ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
