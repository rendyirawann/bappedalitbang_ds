<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\BeritaAlt $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="berita-alt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'berita_id')->textInput() ?>

    <?= $form->field($model, 'file')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
