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
use backend\models\DataKecamatan;
use backend\models\TahunHunian;

/** @var yii\web\View $this */
/** @var backend\models\DataHunian $model */
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

    $(document).on('beforeSubmit', 'form#datahunian', function(){
        $('#loading-overlay').show();
    });

    $(document).on('ajaxComplete', function(){
        $('#loading-overlay').hide();
    });

                initializeChoices(); // Inisialisasi choices pertama kali

");
$this->registerJs("
$(document).on('submit', 'form#datahunian', function(e) {
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

<div class="data-hunian-form">

    <?php $form = ActiveForm::begin([
        'id' => 'datahunian',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'namaPemohon')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-sm-6">

        </div>
        <div class="col-sm-6">

        </div>
    </div>

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

    <?= $form->field($model, 'lokasiBangunan')->textarea(['rows' => 3])->label('Alamat') ?>

    <?= $form->field($model, 'noRegPbg')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jenisBangunan')->dropDownList([
        'Bangunan Kolektif' => 'Bangunan Kolektif',
        'Hunian Tidak Sederhana' => 'Hunian Tidak Sederhana',
        'Rumah Tidak Sederhana' => 'Rumah Tidak Sederhana',
        'Rumah Sederhana' => 'Rumah Sederhana',
        'RTT' => 'RTT',
        'Bangunan Kolektif Sederhana' => 'Bangunan Kolektif Sederhana',
        'Kolektif Perumahan' => 'Kolektif Perumahan',
        'Hunian' => 'Hunian',
        'Rumah Tinggal' => 'Rumah Tinggal'
    ], ['prompt' => 'Pilih Jenis Bangunan'])->label('Jenis Bangunan') ?>

    <?= $form->field($model, 'jlhUnit')->input('number')->label('Jumlah Unit')  ?>

    <?= $form->field($model, 'retribusi')->input('number')->label('Retribusi (Rp.)')  ?>

    <?= $form->field($model, 'tanggal')->textInput(['class' => 'form-control', 'id' => 'datetime-local', 'type' => 'date', 'placeholder' => 'YY/MM/DD'])->label('Tanggal') ?>

    <?= $form->field($model, 'kodeTahun')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\TahunHunian::find()->all(), 'tahun', 'tahun'),
        ['prompt' => 'Pilih Tahun']
    )->label('Tahun') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>