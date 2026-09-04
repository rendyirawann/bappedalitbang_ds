<style>
    #loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }

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
/** @var backend\models\IrigasiBangunan $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJsFile('@web/lightapp/assets/js/plugins/choices.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('@web/css/choices.min.css');
$this->registerJs("
    function initializeChoices() {
        const elements = document.querySelectorAll('[data-trigger]');
        elements.forEach(el => {
            new Choices(el, {
                searchEnabled: true
            });
        });
    }

    $(document).on('shown.bs.modal', '#createModal', function() {
        initializeChoices();
    });

    $(document).on('beforeSubmit', 'form#irigasibangunan', function(){
        $('#loading-overlay').show();
    });

    $(document).on('ajaxComplete', function(){
        $('#loading-overlay').hide();
    });

    initializeChoices(); // Inisialisasi choices pertama kali

    function updateStatus(kondisi, status) {
        let value = parseFloat(kondisi.val());
        if (value > 90) {
            status.val('B');
        } else if (value >= 80) {
            status.val('RR');
        } else if (value >= 60) {
            status.val('RS');
        } else if (value > 0) {
            status.val('RB');
        } else {
            status.val('');
        }
    }

    $(document).ready(function() {
        const fields = [
            {kondisi: '#irigasibangunan-bgnutamakondisi', status: '#irigasibangunan-bgnutamastatus'},
            {kondisi: '#irigasibangunan-bgnpengaturpengukurkondisi', status: '#irigasibangunan-bgnpengaturpengukurstatus'},
            {kondisi: '#irigasibangunan-bgnpembawakondisi', status: '#irigasibangunan-bgnpembawastatus'},
            {kondisi: '#irigasibangunan-bgnlindungkondisi', status: '#irigasibangunan-bgnlindungstatus'},
            {kondisi: '#irigasibangunan-bgnpelengkapkondisi', status: '#irigasibangunan-bgnpelengkapstatus'},
            {kondisi: '#irigasibangunan-saranakondisi', status: '#irigasibangunan-saranastatus'}
        ];

        fields.forEach(function(field) {
            $(field.kondisi).on('input', function() {
                updateStatus($(field.kondisi), $(field.status));
            });
            updateStatus($(field.kondisi), $(field.status)); // Set initial values
        });
    });
");
$this->registerJs("
$(document).ready(function() {
    function calculateRataKondisi() {
        const fields = [
            '#irigasibangunan-bgnutamakondisi',
            '#irigasibangunan-bgnpengaturpengukurkondisi',
            '#irigasibangunan-bgnpembawakondisi',
            '#irigasibangunan-bgnlindungkondisi',
            '#irigasibangunan-bgnpelengkapkondisi',
            '#irigasibangunan-saranakondisi'
        ];

        let total = 0;
        fields.forEach(function(selector) {
            let value = parseFloat($(selector).val()) || 0;
            total += value;
        });

        let pembagi = parseFloat($('#irigasibangunan-pembagiratakondisi').val()) || 1;
        let rataKondisi = total / pembagi;

        $('#irigasibangunan-ratakondisi').val(rataKondisi.toFixed(2));

        let status = '';
        if (rataKondisi > 90) {
            status = 'B';
        } else if (rataKondisi >= 80) {
            status = 'RR';
        } else if (rataKondisi >= 60) {
            status = 'RS';
        } else if (rataKondisi > 0) {
            status = 'RB';
        }

        $('#irigasibangunan-ratastatus').val(status);
    }

    const fields = [
        '#irigasibangunan-bgnutamakondisi',
        '#irigasibangunan-bgnpengaturpengukurkondisi',
        '#irigasibangunan-bgnpembawakondisi',
        '#irigasibangunan-bgnlindungkondisi',
        '#irigasibangunan-bgnpelengkapkondisi',
        '#irigasibangunan-saranakondisi',
        '#irigasibangunan-pembagiratakondisi'
    ];

    fields.forEach(function(field) {
        $(field).on('input', calculateRataKondisi);
    });

    calculateRataKondisi(); // Set initial values
});

");
$this->registerJs("
$(document).on('submit', 'form#irigasibangunan', function(e) {
    e.preventDefault(); // Mencegah form submit biasa

    var \$form = $(this);
    var \$submitBtn = \$form.find(':submit'); // Temukan tombol submit

    // Nonaktifkan tombol submit untuk mencegah klik berulang
    \$submitBtn.prop('disabled', true);

    // Menampilkan overlay loading atau indikator lain jika diperlukan
    $('#loading-overlay').show();

    $.ajax({
        type: \$form.attr('method'),
        url: \$form.attr('action'),
        data: \$form.serialize(),
        success: function(response) {
            if (response.success) {
                window.location.href = response.redirect; // Redirect ke halaman view
            } else {
                // Tampilkan error jika ada
                console.log(response.errors);
            }
        },
        error: function() {
            // Tangani kesalahan AJAX
            console.log('Terjadi kesalahan saat mengirim data.');
        },
        complete: function() {
            // Aktifkan kembali tombol submit dan sembunyikan overlay loading
            \$submitBtn.prop('disabled', false);
            $('#loading-overlay').hide();
        }
    });
});
");
?>

<div class="loading-overlay" id="loading-overlay"></div>

<div class="irigasi-bangunan-form">

    <?php $form = ActiveForm::begin([
        'id' => 'irigasibangunan',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'nomeklatur')->textInput(['maxlength' => true])->label('Nomeklatur/Nama D.I.') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">

        </div>
        <div class="col-sm-6">

        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'kodeDesa')->dropDownList(
                ArrayHelper::map(DataDesa::find()->all(), 'namaDesa', 'namaDesa'),
                ['prompt' => 'Pilih Desa', 'data-trigger' => '']
            )->label('Desa') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'luasIrigasi')->input('number')->label('Luas D.I. Sesuai Permen 14/15 (Ha)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <p class="text-muted" style="font-size:smaller;">*) Baik(B)<br>Rusak Ringan(RR)<br>Rusak Sedang(RS)<br>Rusak Berat(RB)</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bgnUtamaKondisi')->label('Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Utama Nilai Kondisi (%)')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bgnUtamaStatus')->label('Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Utama Status(B/RR/RS/RB)')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bgnPengaturPengukurKondisi')->label('Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pengatur&Pengukur Nilai Kondisi (%)')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bgnPengaturPengukurStatus')->label('Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pengatur&Pengukur Status(B/RR/RS/RB)')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bgnPembawaKondisi')->label('Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pembawa Nilai Kondisi (%)')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bgnPembawaStatus')->label('Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pembawa Status(B/RR/RS/RB)')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bgnLindungKondisi')->label('Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pelindung Nilai Kondisi (%)')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bgnLindungStatus')->label('Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pelindung Status(B/RR/RS/RB)')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bgnPelengkapKondisi')->label('Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pelengkap Nilai Kondisi (%)')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bgnPelengkapStatus')->label('Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pelengkap Status(B/RR/RS/RB)')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'saranaKondisi')->label('Kondisi Fisik Bangunan Irigasi Permukaan - Sarana Nilai Kondisi (%)')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'saranaStatus')->label('Kondisi Fisik Bangunan Irigasi Permukaan - Sarana Status(B/RR/RS/RB)')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'rataKondisi')->label('Rata-Rata Nilai Kondisi (%)')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'pembagiRataKondisi')->label('Nilai Pembagi')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'rataStatus')->label('Rata-Rata Status(B/RR/RS/RB)')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 3]) ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'kodeTahun')->dropDownList(
                \yii\helpers\ArrayHelper::map(\backend\models\TahunIrigasi::find()->all(), 'tahun', 'tahun'),
                ['prompt' => 'Pilih Tahun']
            )->label('Tahun') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>