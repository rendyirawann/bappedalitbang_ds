<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\Unduhan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="unduhan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'namaFile')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'refbidang_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
