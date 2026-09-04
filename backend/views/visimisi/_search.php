<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\VisimisiSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="visimisi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'visiJudul') ?>

    <?= $form->field($model, 'visiTeks') ?>

    <?= $form->field($model, 'misiJudul') ?>

    <?= $form->field($model, 'misiTeks') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
