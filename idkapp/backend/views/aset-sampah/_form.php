<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\AsetSampah $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="aset-sampah-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'namaAset')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
