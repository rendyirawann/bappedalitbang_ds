<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\TblIndividu2022 $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-individu2022-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no')->textInput() ?>

    <?= $form->field($model, 'namaKegiatan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'desa')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kecamatan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>

    <?= $form->field($model, 'anggaran')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
