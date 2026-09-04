<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\JembatanDokumen $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jembatan-dokumen-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kodeDataJembatan')->textInput() ?>

    <?= $form->field($model, 'namaFile')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'file')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
