<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\UnduhanFile $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="unduhan-file-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'refunduhan_id')->textInput() ?>

    <?php if (!$model->isNewRecord && !empty($model->file)): ?>
        <div class="mb-2">
            <label class="control-label">File saat ini</label>
            <p class="form-control-static">
                <?= Html::a(
                    Html::encode($model->file),
                    ['unduhan-file/download', 'id' => $model->id],
                    ['target' => '_blank']
                ) ?>
            </p>
            <p class="help-block">Biarkan kosong jika tidak ingin mengganti file.</p>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'fileUpload')->fileInput([
        'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png',
    ])->hint('Format: PDF, Word, Excel, PowerPoint, JPG, PNG. Maksimal 20 MB.') ?>

    <?= $form->field($model, 'tanggalUpload')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>