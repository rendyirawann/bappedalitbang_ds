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
use backend\models\DataKecamatan;
use backend\models\DataDesa;
use backend\models\TahunJembatan;

/** @var yii\web\View $this */
/** @var backend\models\DataJembatan $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJsFile('@web/js/choices.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('@web/css/choices.min.css');
$this->registerJs("
    $(document).on('beforeSubmit', 'form#datajembatan', function(){
        $('#loading-overlay').show();
    });

    $(document).on('ajaxComplete', function(){
        $('#loading-overlay').hide();
    });

");

$this->registerJs("
    $('#kodeKecamatan').change(function() {
        var kecamatanId = $(this).val();
        $.ajax({
            url: '" . \yii\helpers\Url::to(['get-desa']) . "',
            type: 'GET',
            data: { kodeKecamatan: kecamatanId },
            success: function(data) {
                var options = '<option value=\"\">Pilih Desa</option>';
                $.each(data, function(key, value) {
                    options += '<option value=\"' + key + '\">' + value + '</option>';
                });
                $('#kodeDesa').html(options);
            }
        });
    });
");

?>

<div class="loading-overlay" id="loading-overlay"></div>

<div class="data-jembatan-form">

    <?php $form = ActiveForm::begin([
        'id' => 'datajembatan',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'namaPekerjaan')->textarea(['rows' => 6])->label('Nama Pekerjaan') ?>

    <div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'kodeKecamatan')->dropDownList(
            ArrayHelper::map(DataKecamatan::find()->all(), 'kode', 'namaKecamatan'),
            ['prompt' => 'Pilih Kecamatan', 'id' => 'kodeKecamatan']
        )->label('Kecamatan') ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'kodeDesa')->dropDownList(
            [],
            ['prompt' => 'Pilih Desa', 'id' => 'kodeDesa']
        )->label('Desa') ?>
    </div>
</div>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true])->label('Alamat') ?>

    <?= $form->field($model, 'penyedia')->textInput(['maxlength' => true])->label('Penyedia') ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'nilaiPagu')->input('number')->label('Nilai Pagu (Rp.)')  ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'nilaiKontrak')->input('number')->label('Nilai Kontrak (Rp.)') ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'nilaiAddendum')->input('number')->label('Nilai Kontrak Addendum (Rp.)')  ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'nomorSpmk')->textInput(['maxlength' => true])->label('Nomor dan Tanggal SPMK') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'nomorKontrak')->textInput(['maxlength' => true])->label('Nomor dan Tanggal Kontrak') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'nomorAddendum')->textInput(['maxlength' => true])->label('Nomor dan Tanggal Kontrak Addendum') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'nomorPho')->textInput(['maxlength' => true])->label('PHO Nomor/Tanggal') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'realisasiPanjang')->input('number')->label('Realisasi Panjang (Meter)') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'realisasiLebar')->input('number')->label('Realisasi Lebar (Meter)')  ?>
        </div>
    </div>

    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true])->label('Keterangan') ?>

    <?= $form->field($model, 'tahun')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\TahunJembatan::find()->all(), 'tahun', 'tahun'),
        ['prompt' => 'Pilih Tahun']
    )->label('Tahun') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>