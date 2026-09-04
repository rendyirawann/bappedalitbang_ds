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
/** @var backend\models\SampahDokumen $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJs("
    $(document).on('beforeSubmit', 'form#sampahdokumen', function(){
        $('#loading-overlay').show();
    });

    $(document).on('ajaxComplete', function(){
        $('#loading-overlay').hide();
    });

");
?>

<div class="loading-overlay" id="loading-overlay"></div>

<div class="sampah-dokumen-form">

<?php $form = ActiveForm::begin([
                'id' => 'sampahdokumen',
                'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>

    <?= $form->field($model, 'kodeDataSampah')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'namaFile')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'file_docs[]')->fileInput(['multiple' => true, 'class' => 'form-select mb-2', 'type' => 'file', 'id' => 'formFileMultiple'])->label('Upload Gambar Data Sampah:')->hint('Maksimal Ukuran File Upload per Dokumen: 10MB, Batas Banyak Dokumen Sekali Upload Secara Langsung: 5 File') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
