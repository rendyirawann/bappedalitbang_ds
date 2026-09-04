<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\DanaSepticIndividu $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="dana-septic-individu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sumberDana')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
