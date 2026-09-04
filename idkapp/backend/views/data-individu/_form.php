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
use backend\models\TahunSepticTankIndividu;

/** @var yii\web\View $this */
/** @var backend\models\DataIndividu $model */
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

    $(document).on('beforeSubmit', 'form#dataindividu', function(){
        $('#loading-overlay').show();
    });

    $(document).on('ajaxComplete', function(){
        $('#loading-overlay').hide();
    });

            initializeChoices(); // Inisialisasi choices pertama kali

");
$this->registerJs("
$(document).on('submit', 'form#dataindividu', function(e) {
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

<div class="data-individu-form">

    <?php $form = ActiveForm::begin([
        'id' => 'dataindividu',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'koderef_kegiatan')->textInput(['maxlength' => true])->label('Kode Kegiatan') ?>

    <?= $form->field($model, 'ref_kegiatan')->textInput(['maxlength' => true])->label('Nama Ref Kegiatan') ?>

    <?= $form->field($model, 'koderef_subkegiatan')->textInput(['maxlength' => true])->label('Kode Sub Kegiatan') ?>

    <?= $form->field($model, 'ref_subkegiatan')->textInput(['maxlength' => true])->label('Nama Sub Kegiatan') ?>

    <?= $form->field($model, 'kodeRekening')->textInput(['maxlength' => true])->label('Kode Rekening') ?>

    <?= $form->field($model, 'namaKegiatan')->textarea(['rows' => 6])->label('Nama Kegiatan') ?>

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

    <?= $form->field($model, 'satuan')->textInput(['maxlength' => true])->label('Satuan (Unit)') ?>

    <?= $form->field($model, 'jumlah')->input('number')->label('Jumlah')  ?>

    <?= $form->field($model, 'harga')->input('number')->label('Harga Satuan (Rp.)')  ?>

    <?= $form->field($model, 'kodeDana')->textInput(['maxlength' => true])->label('Keterangan Sumber Dana') ?>

    <?= $form->field($model, 'kodeTahun')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\TahunSepticTankIndividu::find()->all(), 'tahun', 'tahun'),
        ['prompt' => 'Pilih Tahun']
    )->label('Tahun') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>