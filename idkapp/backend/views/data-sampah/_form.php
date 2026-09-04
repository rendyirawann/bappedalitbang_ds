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
use backend\models\DataKecamatan;
use backend\models\DataDesa;

/** @var yii\web\View $this */
/** @var backend\models\DataSampah $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerJsFile('@web/lightapp/assets/js/plugins/choices.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('@web/css/choices.min.css');

// Tambahkan script untuk menginisialisasi choices.js
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

    $(document).on('beforeSubmit', 'form#datasampah', function(){
        $('#loading-overlay').show();
    });

    $(document).on('ajaxComplete', function(){
        $('#loading-overlay').hide();
    });

$(document).on('submit', 'form#datasampah', function(e) {
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

    initializeChoices(); // Inisialisasi choices pertama kali
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

<div class="data-sampah-form">

    <?php $form = ActiveForm::begin([
        'id' => 'datasampah',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'enumerator')->textarea(['rows' => 6])->label('Enumerator') ?>

    <?= $form->field($model, 'fasilitas')->textarea(['rows' => 6])->label('Fasilitas yang Dikelola') ?>

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

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true])->label('Lokasi (Alamat)') ?>

    <?= $form->field($model, 'kondisi')->dropDownList(['Beroperasi' => 'Beroperasi', 'Tidak Beroperasi' => 'Tidak Beroperasi',], ['prompt' => 'Pilih Kondisi Bank Sampah'])->label('Kondisi Pengelolaan (Beroperasi/Tidak Beroperasi)') ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'tahunPembangunan')->input('number')->label('Tahun Pembangunan') ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'tahunOptimalisasi')->input('number')->label('Tahun Optimalisasi (Jika Dilakukan)') ?>
        </div>
    </div>

    <?= $form->field($model, 'kegiatanPengurangan')->textInput(['maxlength' => true])->label('Kegiatan Pengurangan (Pengomposan/Daur Ulang)') ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'jlhSampahMasuk')->input('number')->label('Jumlah Sampah Masuk (Ton/Hari)') ?>
        </div>

        <div class="col-sm-5">
            <?= $form->field($model, 'jlhSampahKompos')->input('number')->label('Jumlah Sampah Masuk yang Terolah menjadi Bahan Baku/Kompos (Ton/Hari)') ?>
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, 'jlhSampahResidu')->input('number')->label('Jumlah Sampah Residu yang Dibawa ke TPA (Ton/Hari)') ?>
        </div>
    </div>

    <?= $form->field($model, 'kodePengelola')->textInput(['maxlength' => true])->label('Pengelola(KSM/Dinas/UPTD)') ?>

    <?= $form->field($model, 'namaLembaga')->textInput(['maxlength' => true])->label('Nama Lembaga/Kelompok dan Tahun Pendirian') ?>

    <?= $form->field($model, 'bentukLembaga')->textInput(['maxlength' => true])->label('Bentuk Lembaga/Kelompok dan Dasar Pembentukan') ?>

    <?= $form->field($model, 'jlhAnggota')->input('number')->label('Jumlah Anggota/Pengurus (Orang)') ?>

    <?= $form->field($model, 'kodeBidang')->textInput(['maxlength' => true])->label('Bidang yang Kelola') ?>

    <?= $form->field($model, 'wilayah')->textInput(['maxlength' => true])->label('Cakupan Wilayah') ?>

    <?= $form->field($model, 'kodeDana')->textInput(['maxlength' => true])->label('Sumberdana Operasional') ?>

    <?= $form->field($model, 'kodeAset')->textInput(['maxlength' => true])->label('Aset Barang dan Sumber Pengadaan') ?>

    <?= $form->field($model, 'status')->dropDownList(['Beroperasi' => 'Beroperasi', 'Tidak Beroperasi' => 'Tidak Beroperasi',], ['prompt' => 'Pilih Status Bank Sampah'])->label('Status/Keterangan (Beroperasi / Tidak Beroperasi)') ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'latitude')->textInput(['maxlength' => true])->label('Koordinat Lokasi Sarpras (Latitude)') ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'longitude')->textInput(['maxlength' => true])->label('Koordinat Lokasi Sarpras (Longitude)') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>