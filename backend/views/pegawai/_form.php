<style>
    #loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Dark semi-transparent background */
        z-index: 9999; /* Make sure it's on top of everything */
    }

    /* Style the loading spinner (optional) */
    #loading-overlay:after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 40px;
        height: 40px;
        margin-top: -20px;
        margin-left: -20px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Pegawai $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJs("
    $(document).on('beforeSubmit', 'form#pegawai', function(){
        $('#loading-overlay').show();
    });

    $(document).on('ajaxComplete', function(){
        $('#loading-overlay').hide();
    });

");
?>
<div class="loading-overlay" id="loading-overlay"></div>

<div class="pegawai-form">

    <?php $form = ActiveForm::begin([
                'id' => 'pegawai',
                'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>

    <?= $form->field($model, 'statusAparatur')->radioList(array(1=>'ASN',2=>'Non ASN')); ?>

    <?= $form->field($model, 'namaLengkap')->textInput(['maxlength' => true, 'class' => 'form-control mb-2']) ?>

    <?= $form->field($model, 'nip')->textInput(['maxlength' => true, 'class' => 'form-control mb-2', 'type' => 'number'])->label('NIP') ?>

    <?= $form->field($model, 'eselon')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\PegawaiEselon::find()->all(), 'id', 'nm_eselon'),
        ['prompt' => 'Pilih Tingkat Eselon', 'class' => 'form-select mb-2']
    ) ?>

    <?= $form->field($model, 'kodeBidang')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\Bidang::find()->all(), 'id', 'bidang'),
        ['prompt' => 'Pilih Bidang', 'class' => 'form-select mb-2']
    ) ?>

    <?= $form->field($model, 'kodeTitle')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\Title::find()->all(), 'id', 'title'),
        ['prompt' => 'Pilih Jabatan', 'class' => 'form-select mb-2']
    ) ?>

    <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true, 'type' => 'number', 'class' => 'form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success mt-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
