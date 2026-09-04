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
use backend\models\DataJalan;
use backend\models\DataKecamatan;
use backend\models\DataDesa;
use backend\models\BidangIpald;
use backend\models\DanaIpald;
use backend\models\AsetIpald;
use backend\models\StatusAset;
use backend\models\DataPengelola;

/** @var yii\web\View $this */
/** @var backend\models\DataIpald $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJsFile('@web/js/choices.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('@web/css/choices.min.css');
$this->registerJs("
    $(document).on('beforeSubmit', 'form#dataipald', function(){
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

<div class="data-ipald-form">

    <?php $form = ActiveForm::begin([
        'id' => 'dataipald',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'enumerator')->textInput()->label('Enumerator') ?>

    <?= $form->field($model, 'fasilitas')->textarea(['rows' => 2])->label('Fasilitas') ?>

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

    <?= $form->field($model, 'alamat')->textarea(['rows' => 6])->label('Alamat') ?>

    <div class="row">
        <div class="col-sm-6">

        </div>
        <div class="col-sm-6">

        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'tahunPembangunan')->input('number')->label('Tahun Pembangunan') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'tahunRehabilitasi')->input('number')->label('Tahun Rehabilitasi') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'kapasitasDesain')->input('number')->label('Kapasitas Desain SR') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'kapasitasPakai')->input('number')->label('Kapasitas Pakai SR') ?>
        </div>
    </div>

    <?= $form->field($model, 'sistem')->textarea(['rows' => 2])->label('Sistem yang digunakan') ?>

    <?= $form->field($model, 'kondisi')->radioList(['Rusak' => 'Rusak', 'Baik' => 'Baik'])->label('Kondisi Bangunan') ?>

    <?= $form->field($model, 'kodePengelola')->textInput()->label('Pengelola (Dinas/UPTD/Masyarakat)') ?>

    <?= $form->field($model, 'cekEffluent')->radioList(['Tidak Dilakukan' => 'Tidak Dilakukan', 'Dilakukan' => 'Dilakukan'])->label('Pengecekan Effluent') ?>

    <?= $form->field($model, 'namaLembaga')->textInput(['maxlength' => true])->label('Nama Lembaga/Kelompok dan tahun pendirian') ?>

    <?= $form->field($model, 'bentukLembaga')->textInput(['maxlength' => true])->label('Bentuk lembaga/Kelompok
dan dasar pembentukan') ?>

    <?= $form->field($model, 'jumlahAnggota')->input('number')->label('Jumlah anggota/Pengurus (Orang)') ?>

    <?= $form->field($model, 'kodeBidang')->textInput()->label('Bidang yang kelola') ?>

    <?= $form->field($model, 'kodeDana')->textInput()->label('Sumber dana operasional') ?>

    <?= $form->field($model, 'kodeAset')->textInput()->label('Aset barang dan sumber pengadaan') ?>

    <?= $form->field($model, 'kodeStatus')->textInput()->label('Status Aset') ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'latitude')->textInput(['maxlength' => true])->label('Koordinat Sarpras (latitude)') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'longitude')->textInput(['maxlength' => true])->label('Koordinat Sarpras (longitude)') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>