<style>
    #loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        /* Dark semi-transparent background */
        z-index: 9999;
        /* Make sure it's on top of everything */
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
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\DataDesa;

/** @var yii\web\View $this */
/** @var backend\models\IrigasiTerdampak $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJsFile('@web/lightapp/assets/js/plugins/choices.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('@web/css/choices.min.css');
$this->registerJs("
    $(document).on('beforeSubmit', 'form#irigasiterdampak', function(){
        $('#loading-overlay').show();
    });

    $(document).on('ajaxComplete', function(){
        $('#loading-overlay').hide();
    });

");

// JavaScript untuk menghitung total otomatis
$this->registerJs("
    function calculateTotal() {
        let arealBaik = parseFloat($('#irigasiterdampak-arealbaik').val()) || 0;
        let arealRusakRingan = parseFloat($('#irigasiterdampak-arealrusakringan').val()) || 0;
        let arealRusakSedang = parseFloat($('#irigasiterdampak-arealrusaksedang').val()) || 0;
        let arealRusakBerat = parseFloat($('#irigasiterdampak-arealrusakberat').val()) || 0;

        let total = arealBaik + arealRusakRingan + arealRusakSedang + arealRusakBerat;
        $('#irigasiterdampak-total').val(total);
    }

    function validateDecimal(input) {
        return !input.includes(',');
    }

    function showError(message) {
        alert(message);
    }

    $(document).on('input', '#irigasiterdampak-arealbaik, #irigasiterdampak-arealrusakringan, #irigasiterdampak-arealrusaksedang, #irigasiterdampak-arealrusakberat', function() {
        let input = $(this).val();
        if (!validateDecimal(input)) {
            showError('Gunakan tanda titik (.) untuk desimal.');
            $(this).val(input.replace(/,/g, '.'));
        }
        calculateTotal();
    });

    $(document).on('beforeSubmit', 'form#irigasiterdampak', function() {
        calculateTotal();
    });
");
?>

<div class="loading-overlay" id="loading-overlay"></div>

<div class="irigasi-terdampak-form">

    <?php $form = ActiveForm::begin([
        'id' => 'irigasiterdampak',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'nomeklatur')->textInput(['maxlength' => true])->label('Nomeklatur/Nama D.I.') ?>

    <?= $form->field($model, 'kodeDesa')->dropDownList(
        ArrayHelper::map(DataDesa::find()->all(), 'namaDesa', 'namaDesa'),
        ['prompt' => 'Pilih Desa', 'data-trigger' => '']
    )->label('Desa') ?>

    <?= $form->field($model, 'luasIrigasi')->input('number')->label('Luas D.I. Sesuai Permen 14/15 (Ha)') ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'arealBaik')->textInput(['maxlength' => true])->label('Areal Terdampak - Baik (Ha)') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'arealRusakRingan')->textInput(['maxlength' => true])->label('Areal Terdampak - Rusak Ringan (Ha)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'arealRusakSedang')->textInput(['maxlength' => true])->label('Areal Terdampak - Rusak Sedang (Ha)') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'arealRusakBerat')->textInput(['maxlength' => true])->label('Areal Terdampak - Rusak Berat (Ha)') ?>
        </div>
    </div>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true, 'readonly' => true])->label('Areal Terdampak - Total (Ha)') ?>

    <?= $form->field($model, 'kodeTahun')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\TahunIrigasi::find()->all(), 'tahun', 'tahun'),
        ['prompt' => 'Pilih Tahun']
    )->label('Tahun') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>