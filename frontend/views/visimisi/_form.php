<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\Visimisi $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="visimisi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'visiJudul')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'visiTeks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'misiJudul')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'misiTeks')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
