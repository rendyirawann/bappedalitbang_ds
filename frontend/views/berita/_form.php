<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\Berita $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="berita-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'judulBerita')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isiBerita')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'bidang_id')->textInput() ?>

    <?= $form->field($model, 'tgl_berita')->textInput() ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
