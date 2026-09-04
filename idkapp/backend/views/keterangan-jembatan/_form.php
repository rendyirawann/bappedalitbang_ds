<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\KeteranganJembatan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="keterangan-jembatan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'namaKeterangan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
