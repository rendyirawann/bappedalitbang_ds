<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\BidangSampah $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="bidang-sampah-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'namaBidang')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
