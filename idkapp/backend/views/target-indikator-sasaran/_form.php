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
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\TargetIndikatorSasaran $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJsFile('@web/lightapp/assets/js/plugins/choices.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('@web/css/choices.min.css');
$this->registerJs("

    $(document).on('beforeSubmit', 'form#capkin', function(){
        $('#loading-overlay').show();
    });

    $(document).on('ajaxComplete', function(){
        $('#loading-overlay').hide();
    });


");
?>

<div class="loading-overlay" id="loading-overlay"></div>

<div class="target-indikator-sasaran-form">

    <?php $form = ActiveForm::begin([
        'id' => 'capkin',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'indikator_id')->hiddenInput(['readonly' => true])->label(false) ?>

    <?= $form->field($model, 'cascadingrenstrasasaran_id')->hiddenInput(['readonly' => true])->label(false) ?>

    <?= $form->field($model, 'refsasaranrenstra_id')->hiddenInput(['readonly' => true])->label(false) ?>

    <?= $form->field($model, 'refskpd_id')->hiddenInput(['maxlength' => true, 'readonly' => true])->label(false) ?>

    <?= $form->field($model, 'tahun_id')->hiddenInput(['readonly' => true, 'readonly' => true])->label(false) ?>

    <?= $form->field($model, 'target')->hiddenInput(['maxlength' => true, 'readonly' => true])->label(false) ?>

    <?= $form->field($model, 'target_rkt_p')->hiddenInput(['maxlength' => true, 'readonly' => true])->label(false) ?>

    <?= $form->field($model, 'sebab_rkt_p')->hiddenInput(['rows' => 6, 'readonly' => true])->label(false) ?>

    <?= $form->field($model, 'target_pk')->hiddenInput(['maxlength' => true, 'readonly' => true])->label(false) ?>

    <?= $form->field($model, 'sebab_pk')->hiddenInput(['rows' => 6, 'readonly' => true])->label(false) ?>

    <?= $form->field($model, 'target_pk_p')->textInput(['maxlength' => true, 'id' => 'target_pk_p']) ?>

    <?= $form->field($model, 'sebab_pk_p')->hiddenInput(['rows' => 6, 'readonly' => true])->label(false) ?>

    <?= $form->field($model, 'realisasi')->textInput(['maxlength' => true, 'id' => 'realisasi']) ?>

    <?= $form->field($model, 'capaian')->textInput(['maxlength' => true, 'id' => 'capaian', 'readonly' => true]) ?>

    <?= $form->field($model, 'keterangan')->hiddenInput(['rows' => 6, 'readonly' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    $script = <<< JS
    function updateCapaian() {
        var target_pk_p = parseFloat($('#target_pk_p').val());
        var realisasi = parseFloat($('#realisasi').val());
        
        if (!isNaN(target_pk_p) && !isNaN(realisasi) && target_pk_p != 0) {
            var capaian = (realisasi / target_pk_p) * 100;
            $('#capaian').val(capaian.toFixed(2));
        } else {
            $('#capaian').val('');
        }
    }

    $('#target_pk_p, #realisasi').on('input', updateCapaian);
JS;
    $this->registerJs($script);
    ?>



</div>