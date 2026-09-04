<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UploadForm */

$this->title = 'Upload CSV to Database';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-individu2022-upload">

    <div class="tbl-ipald-form">

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>

        <?= $form->field($model, 'file')->fileInput()->label('Upload CSV')->hint('Maksimal Ukuran File Upload: 10MB') ?>

        <div class="form-group">
            <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
