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
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\DataDesa;
use backend\models\TahunIrigasi;

/** @var yii\web\View $this */
/** @var backend\models\IrigasiSaluran $model */
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

    $(document).on('beforeSubmit', 'form#irigasisaluran', function(){
        $('#loading-overlay').show();
    });

    $(document).on('ajaxComplete', function(){
        $('#loading-overlay').hide();
    });

    initializeChoices();
");

// Tambahkan script untuk logika pengisian otomatis
$this->registerJs("
    function updateSaluranStatus() {
        var kondisiBaik = parseFloat($('#irigasisaluran-primerkondisibaik').val());
        var status = '';
        if (kondisiBaik > 90) {
            status = 'B';
        } else if (kondisiBaik >= 80) {
            status = 'RR';
        } else if (kondisiBaik >= 60) {
            status = 'RS';
        } else if (kondisiBaik > 0) {
            status = 'RB';
        }
        $('#irigasisaluran-primersaluranstatus').val(status);
    }

    function updateSaluranBaik() {
        var pjgSaluran = parseFloat($('#irigasisaluran-primerpjgsaluran').val());
        var kondisiBaik = parseFloat($('#irigasisaluran-primerkondisibaik').val());
        var saluranBaik = pjgSaluran * kondisiBaik;
        $('#irigasisaluran-primersaluranbaik').val(saluranBaik);
    }

    function updateSekunderStatus() {
        var kondisiBaik = parseFloat($('#irigasisaluran-sekunderkondisibaik').val());
        var status = '';
        if (kondisiBaik > 90) {
            status = 'B';
        } else if (kondisiBaik >= 80) {
            status = 'RR';
        } else if (kondisiBaik >= 60) {
            status = 'RS';
        } else if (kondisiBaik > 0) {
            status = 'RB';
        }
        $('#irigasisaluran-sekundersaluranstatus').val(status);
    }

    function updateSekunderBaik() {
        var pjgSaluran = parseFloat($('#irigasisaluran-sekunderpjgsaluran').val());
        var kondisiBaik = parseFloat($('#irigasisaluran-sekunderkondisibaik').val());
        var saluranBaik = pjgSaluran * kondisiBaik;
        $('#irigasisaluran-sekundersaluranbaik').val(saluranBaik);
    }

    function updatePembuangStatus() {
        var kondisiBaik = parseFloat($('#irigasisaluran-pembuangkondisibaik').val());
        var status = '';
        if (kondisiBaik > 90) {
            status = 'B';
        } else if (kondisiBaik >= 80) {
            status = 'RR';
        } else if (kondisiBaik >= 60) {
            status = 'RS';
        } else if (kondisiBaik > 0) {
            status = 'RB';
        }
        $('#irigasisaluran-pembuangsaluranstatus').val(status);
    }

    function updateBangunanBagiStatus() {
        var kondisiBaik = parseFloat($('#irigasisaluran-bangunanbagikondisibaik').val());
        var status = '';
        if (kondisiBaik > 90) {
            status = 'B';
        } else if (kondisiBaik >= 80) {
            status = 'RR';
        } else if (kondisiBaik >= 60) {
            status = 'RS';
        } else if (kondisiBaik > 0) {
            status = 'RB';
        }
        $('#irigasisaluran-bangunanbagistatus').val(status);
    }

    function updateBangunanBagiSadapStatus() {
        var kondisiBaik = parseFloat($('#irigasisaluran-bangunanbagisadapkondisibaik').val());
        var status = '';
        if (kondisiBaik > 90) {
            status = 'B';
        } else if (kondisiBaik >= 80) {
            status = 'RR';
        } else if (kondisiBaik >= 60) {
            status = 'RS';
        } else if (kondisiBaik > 0) {
            status = 'RB';
        }
        $('#irigasisaluran-bangunanbagisadapstatus').val(status);
    }


    function updateBangunanSadapStatus() {
        var kondisiBaik = parseFloat($('#irigasisaluran-bangunansadapkondisibaik').val());
        var status = '';
        if (kondisiBaik > 90) {
            status = 'B';
        } else if (kondisiBaik >= 80) {
            status = 'RR';
        } else if (kondisiBaik >= 60) {
            status = 'RS';
        } else if (kondisiBaik > 0) {
            status = 'RB';
        }
        $('#irigasisaluran-bangunansadapstatus').val(status);
    }

    function updateBangunanPintuAirStatus() {
        var kondisiBaik = parseFloat($('#irigasisaluran-bangunanpintuairkondisibaik').val());
        var status = '';
        if (kondisiBaik > 90) {
            status = 'B';
        } else if (kondisiBaik >= 80) {
            status = 'RR';
        } else if (kondisiBaik >= 60) {
            status = 'RS';
        } else if (kondisiBaik > 0) {
            status = 'RB';
        }
        $('#irigasisaluran-bangunanpintuairstatus').val(status);
    }

    function updateBangunanTalangStatus() {
        var kondisiBaik = parseFloat($('#irigasisaluran-bangunantalangkondisibaik').val());
        var status = '';
        if (kondisiBaik > 90) {
            status = 'B';
        } else if (kondisiBaik >= 80) {
            status = 'RR';
        } else if (kondisiBaik >= 60) {
            status = 'RS';
        } else if (kondisiBaik > 0) {
            status = 'RB';
        }
        $('#irigasisaluran-bangunantalangstatus').val(status);
    }

    function updateBangunanSiponStatus() {
        var kondisiBaik = parseFloat($('#irigasisaluran-bangunansiponkondisibaik').val());
        var status = '';
        if (kondisiBaik > 90) {
            status = 'B';
        } else if (kondisiBaik >= 80) {
            status = 'RR';
        } else if (kondisiBaik >= 60) {
            status = 'RS';
        } else if (kondisiBaik > 0) {
            status = 'RB';
        }
        $('#irigasisaluran-bangunansiponstatus').val(status);
    }

    function updateBangunanGorongStatus() {
        var kondisiBaik = parseFloat($('#irigasisaluran-bangunangorongkondisibaik').val());
        var status = '';
        if (kondisiBaik > 90) {
            status = 'B';
        } else if (kondisiBaik >= 80) {
            status = 'RR';
        } else if (kondisiBaik >= 60) {
            status = 'RS';
        } else if (kondisiBaik > 0) {
            status = 'RB';
        }
        $('#irigasisaluran-bangunangorongstatus').val(status);
    }

    function updateBangunanTerjunStatus() {
        var kondisiBaik = parseFloat($('#irigasisaluran-bangunanterjunkondisibaik').val());
        var status = '';
        if (kondisiBaik > 90) {
            status = 'B';
        } else if (kondisiBaik >= 80) {
            status = 'RR';
        } else if (kondisiBaik >= 60) {
            status = 'RS';
        } else if (kondisiBaik > 0) {
            status = 'RB';
        }
        $('#irigasisaluran-bangunanterjunstatus').val(status);
    }

    function updateBangunanTanggulStatus() {
        var kondisiBaik = parseFloat($('#irigasisaluran-bangunantanggulkondisibaik').val());
        var status = '';
        if (kondisiBaik > 90) {
            status = 'B';
        } else if (kondisiBaik >= 80) {
            status = 'RR';
        } else if (kondisiBaik >= 60) {
            status = 'RS';
        } else if (kondisiBaik > 0) {
            status = 'RB';
        }
        $('#irigasisaluran-bangunantanggulstatus').val(status);
    }
        
function updateRataJaringanKondisiBaik() {
        let primer = parseFloat(document.getElementById('irigasisaluran-primerkondisibaik').value) || 0;
        let sekunder = parseFloat(document.getElementById('irigasisaluran-sekunderkondisibaik').value) || 0;
        let pembuang = parseFloat(document.getElementById('irigasisaluran-pembuangkondisibaik').value) || 0;
        let bangunanBagi = parseFloat(document.getElementById('irigasisaluran-bangunanbagikondisibaik').value) || 0;
        let bangunanBagiSadap = parseFloat(document.getElementById('irigasisaluran-bangunanbagisadapkondisibaik').value) || 0;
        let bangunanSadap = parseFloat(document.getElementById('irigasisaluran-bangunansadapkondisibaik').value) || 0;
        let bangunanPintuAir = parseFloat(document.getElementById('irigasisaluran-bangunanpintuairkondisibaik').value) || 0;
        let bangunanTalang = parseFloat(document.getElementById('irigasisaluran-bangunantalangkondisibaik').value) || 0;
        let bangunanSipon = parseFloat(document.getElementById('irigasisaluran-bangunansiponkondisibaik').value) || 0;
        let bangunanGorong = parseFloat(document.getElementById('irigasisaluran-bangunangorongkondisibaik').value) || 0;
        let bangunanTerjun = parseFloat(document.getElementById('irigasisaluran-bangunanterjunkondisibaik').value) || 0;
        let bangunanTanggul = parseFloat(document.getElementById('irigasisaluran-bangunantanggulkondisibaik').value) || 0;

        let total = primer + sekunder + pembuang + bangunanBagi + bangunanBagiSadap + bangunanSadap + bangunanPintuAir + bangunanTalang + bangunanSipon + bangunanGorong + bangunanTerjun + bangunanTanggul;

        let pembagi = parseFloat(document.getElementById('irigasisaluran-pembagiratakondisi').value) || 1;

        let rataJaringanKondisiBaik = total / pembagi;
        document.getElementById('irigasisaluran-ratajaringankondisibaik').value = rataJaringanKondisiBaik.toFixed(2);

        let status = '';
        if (rataJaringanKondisiBaik > 90) {
            status = 'B';
        } else if (rataJaringanKondisiBaik >= 80) {
            status = 'RR';
        } else if (rataJaringanKondisiBaik >= 60) {
            status = 'RS';
        } else if (rataJaringanKondisiBaik > 0) {
            status = 'RB';
        }

        document.getElementById('irigasisaluran-ratajaringanstatus').value = status;
    }

    document.getElementById('irigasisaluran-pembagiratakondisi').addEventListener('input', updateRataJaringanKondisiBaik);
    document.querySelectorAll('#irigasisaluran-primerkondisibaik, #irigasisaluran-sekunderkondisibaik, #irigasisaluran-pembuangkondisibaik, #irigasisaluran-bangunanbagikondisibaik, #irigasisaluran-bangunanbagisadapkondisibaik, #irigasisaluran-bangunansadapkondisibaik, #irigasisaluran-bangunanpintuairkondisibaik, #irigasisaluran-bangunantalangkondisibaik, #irigasisaluran-bangunansiponkondisibaik, #irigasisaluran-bangunangorongkondisibaik, #irigasisaluran-bangunanterjunkondisibaik, #irigasisaluran-bangunantanggulkondisibaik').forEach(function(element) {
        element.addEventListener('input', updateRataJaringanKondisiBaik);
    });

     function updateArealTotal() {
        let arealBaik = parseFloat(document.getElementById('irigasisaluran-arealbaik').value) || 0;
        let arealRusakRingan = parseFloat(document.getElementById('irigasisaluran-arealrusakringan').value) || 0;
        let arealRusakSedang = parseFloat(document.getElementById('irigasisaluran-arealrusaksedang').value) || 0;
        let arealRusakBerat = parseFloat(document.getElementById('irigasisaluran-arealrusakberat').value) || 0;

        let arealTotal = arealBaik + arealRusakRingan + arealRusakSedang + arealRusakBerat;
        document.getElementById('irigasisaluran-arealtotal').value = arealTotal.toFixed(2);
    }

    document.querySelectorAll('#irigasisaluran-arealbaik, #irigasisaluran-arealrusakringan, #irigasisaluran-arealrusaksedang, #irigasisaluran-arealrusakberat').forEach(function(element) {
        element.addEventListener('input', updateArealTotal);
    });

    function updateIndeksJumlah() {
        let indeksPrasaranaFisik = parseFloat(document.getElementById('irigasisaluran-indeksprasaranafisik').value) || 0;
        let indeksProduktivitas = parseFloat(document.getElementById('irigasisaluran-indeksproduktivitas').value) || 0;
        let indeksSaranaPenunjang = parseFloat(document.getElementById('irigasisaluran-indekssaranapenunjang').value) || 0;
        let indeksOrganisasiPersonalia = parseFloat(document.getElementById('irigasisaluran-indeksorganisasipersonalia').value) || 0;
        let indeksDokumentasi = parseFloat(document.getElementById('irigasisaluran-indeksdokumentasi').value) || 0;
        let indeksPpa = parseFloat(document.getElementById('irigasisaluran-indeksppa').value) || 0;

        let indeksJumlah = indeksPrasaranaFisik + indeksProduktivitas + indeksSaranaPenunjang + indeksOrganisasiPersonalia + indeksDokumentasi + indeksPpa;
        document.getElementById('irigasisaluran-indeksjumlah').value = indeksJumlah.toFixed(2);
                updateIndeksKategori(indeksJumlah);
    }

    document.querySelectorAll('#irigasisaluran-indeksprasaranafisik, #irigasisaluran-indeksproduktivitas, #irigasisaluran-indekssaranapenunjang, #irigasisaluran-indeksorganisasipersonalia, #irigasisaluran-indeksdokumentasi, #irigasisaluran-indeksppa').forEach(function(element) {
        element.addEventListener('input', updateIndeksJumlah);
    });

    function updateIndeksKategori(indeksJumlah) {
        let indeksKategori = '';
        if (indeksJumlah > 90) {
            indeksKategori = 'SB';
        } else if (indeksJumlah >= 80) {
            indeksKategori = 'B';
        } else if (indeksJumlah >= 60) {
            indeksKategori = 'K';
        } else if (indeksJumlah > 0) {
            indeksKategori = 'J';
        }
        document.getElementById('irigasisaluran-indekskategori').value = indeksKategori;
    }

    $(document).on('input', '#irigasisaluran-primerkondisibaik', function() {
        updateSaluranStatus();
        updateSaluranBaik();
    });

    $(document).on('input', '#irigasisaluran-primerpjgsaluran', function() {
        updateSaluranBaik();
    });

    $(document).on('input', '#irigasisaluran-sekunderkondisibaik', function() {
        updateSekunderStatus();
        updateSekunderBaik();
    });

    $(document).on('input', '#irigasisaluran-sekunderpjgsaluran', function() {
        updateSekunderBaik();
    });

    $(document).on('input', '#irigasisaluran-pembuangkondisibaik', function() {
        updatePembuangStatus();
    });

    $(document).on('input', '#irigasisaluran-bangunanbagikondisibaik', function() {
        updateBangunanBagiStatus();
    });

    $(document).on('input', '#irigasisaluran-bangunanbagisadapkondisibaik', function() {
        updateBangunanBagiSadapStatus();
    });

    $(document).on('input', '#irigasisaluran-bangunansadapkondisibaik', function() {
        updateBangunanSadapStatus();
    });

    $(document).on('input', '#irigasisaluran-bangunanpintuairkondisibaik', function() {
        updateBangunanPintuAirStatus();
    });

    $(document).on('input', '#irigasisaluran-bangunantalangkondisibaik', function() {
        updateBangunanTalangStatus();
    });

    $(document).on('input', '#irigasisaluran-bangunansiponkondisibaik', function() {
        updateBangunanSiponStatus();
    });

    $(document).on('input', '#irigasisaluran-bangunangorongkondisibaik', function() {
        updateBangunanGorongStatus();
    });

    $(document).on('input', '#irigasisaluran-bangunanterjunkondisibaik', function() {
        updateBangunanTerjunStatus();
    });

    $(document).on('input', '#irigasisaluran-bangunantanggulkondisibaik', function() {
        updateBangunanTanggulStatus();
    });

");

$this->registerJs("
$(document).on('submit', 'form#irigasisaluran', function(e) {
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

<div class="irigasi-saluran-form">

    <?php $form = ActiveForm::begin([
        'id' => 'irigasisaluran',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'nomeklatur')->textInput(['maxlength' => true])->label('Nomeklatur/Nama D.I.') ?>

    <?= $form->field($model, 'kodeDesa')->dropDownList(
        ArrayHelper::map(DataDesa::find()->all(), 'namaDesa', 'namaDesa'),
        ['prompt' => 'Pilih Desa', 'data-trigger' => '']
    )->label('Desa') ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'luasIrigasi')->input('number')->label('Luas D.I. Sesuai Permen 14/15 (Ha)') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'igt')->textInput()->label('Sawah/Fungsional (Pemetaan IGT) (Ha)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'primerKondisiBaik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-primerkondisibaik'])->label('Saluran Primer - (%) Kondisi Baik') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'primerSaluranStatus')->textarea(['rows' => 6, 'readonly' => true, 'id' => 'irigasisaluran-primersaluranstatus'])->label('Saluran Primer - Status (B/RR/RS/RB)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'primerPjgSaluran')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-primerpjgsaluran'])->label('Saluran Primer - Total Panjang Saluran (m)') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'primerSaluranBaik')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'irigasisaluran-primersaluranbaik'])->label('Saluran Primer - Saluran Kondisi Baik (m)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'sekunderKondisiBaik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-sekunderkondisibaik'])->label('Saluran Sekunder - (%) Kondisi Baik') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'sekunderSaluranStatus')->textarea(['rows' => 6, 'readonly' => true, 'id' => 'irigasisaluran-sekundersaluranstatus'])->label('Saluran Sekunder - Status (B/RR/RS/RB)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'sekunderPjgSaluran')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-sekunderpjgsaluran'])->label('Saluran Sekunder - Total Panjang Saluran (m)') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'sekunderSaluranBaik')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'irigasisaluran-sekundersaluranbaik'])->label('Saluran Sekunder - Saluran Kondisi Baik (m)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'pembuangKondisiBaik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-pembuangkondisibaik'])->label('Saluran Pembuang - (%) Kondisi Baik') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'pembuangSaluranStatus')->textarea(['rows' => 6, 'readonly' => true])->label('Saluran Pembuang - Status (B/RR/RS/RB)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanBagiKondisiBaik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-bangunanbagikondisibaik'])->label('Bangunan Bagi** - (%) Kondisi Baik') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanBagiStatus')->textarea(['rows' => 6, 'readonly' => true])->label('Bangunan Bagi** - Status (B/RR/RS/RB)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanBagiSadapKondisiBaik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-bangunanbagisadapkondisibaik'])->label('Bangunan Bagi Sadap** - (%) Kondisi Baik') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanBagiSadapStatus')->textarea(['rows' => 6, 'readonly' => true])->label('Bangunan Bagi Sadap** - Status (B/RR/RS/RB)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanSadapKondisiBaik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-bangunansadapkondisibaik'])->label('Bangunan Sadap** - (%) Kondisi Baik') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanSadapStatus')->textarea(['rows' => 6, 'readonly' => true])->label('Bangunan Sadap** - Status (B/RR/RS/RB)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanPintuAirKondisiBaik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-bangunanpintuairkondisibaik'])->label('Bangunan Pintu Air** - (%) Kondisi Baik') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanPintuAirStatus')->textarea(['rows' => 6, 'readonly' => true])->label('Bangunan Air Status** - Status (B/RR/RS/RB)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanTalangKondisiBaik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-bangunantalangkondisibaik'])->label('Bangunan Talang** - (%) Kondisi Baik') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanTalangStatus')->textarea(['rows' => 6, 'readonly' => true])->label('Bangunan Talang** - Status (B/RR/RS/RB)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanSiponKondisiBaik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-bangunansiponkondisibaik'])->label('Bangunan Sipon** - (%) Kondisi Baik')  ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanSiponStatus')->textarea(['rows' => 6, 'readonly' => true])->label('Bangunan Sipon** - Status (B/RR/RS/RB)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanGorongKondisiBaik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-bangunangorongkondisibaik'])->label('Bangunan Gorong** - (%) Kondisi Baik') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanGorongStatus')->textarea(['rows' => 6, 'readonly' => true])->label('Bangunan Gorong** - Status (B/RR/RS/RB)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanTerjunKondisiBaik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-bangunanterjunkondisibaik'])->label('Bangunan Terjun** - (%) Kondisi Baik') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanTerjunStatus')->textarea(['rows' => 6, 'readonly' => true])->label('Bangunan Terjun** - Status (B/RR/RS/RB)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanTanggulKondisiBaik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-bangunantanggulkondisibaik'])->label('Bangunan Tanggul** - (%) Kondisi Baik') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'bangunanTanggulStatus')->textarea(['rows' => 6, 'readonly' => true])->label('Bangunan Tanggul** - Status (B/RR/RS/RB)') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'rataJaringanKondisiBaik')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'irigasisaluran-ratajaringankondisibaik'])->label('Bangunan Rata-Rata Jaringan - (%) Kondisi Baik') ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'pembagiRataKondisi')->textInput(['id' => 'irigasisaluran-pembagiratakondisi'])->label('Bangunan Rata-Rata - Pembagi') ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'rataJaringanStatus')->textarea(['rows' => 6, 'readonly' => true, 'id' => 'irigasisaluran-ratajaringanstatus'])->label('Bangunan Rata-Rata - Status (B/RR/RS/RB)') ?>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'arealBaik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-arealbaik'])->label('Areal Terdampak - Baik (Ha)') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'arealRusakRingan')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-arealrusakringan'])->label('Areal Terdampak - Rusak Ringan (Ha)') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'arealRusakSedang')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-arealrusaksedang'])->label('Areal Terdampak - Rusak Sedang (Ha)') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'arealRusakBerat')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-arealrusakberat'])->label('Areal Terdampak - Rusak Berat (Ha)') ?>
        </div>
    </div>

    <?= $form->field($model, 'arealTotal')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'irigasisaluran-arealtotal'])->label('Areal Terdampak - Total (Ha)') ?>

    <?= $form->field($model, 'indeksPrasaranaFisik')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-indeksprasaranafisik'])->label('Indeks Kinerja Sistem Irigasi Permukaan - Prasarana Fisik (Nilai Maks 45%)') ?>

    <?= $form->field($model, 'indeksProduktivitas')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-indeksproduktivitas'])->label('Indeks Kinerja Sistem Irigasi Permukaan - Produktivitas (Nilai Maks 15%)') ?>

    <?= $form->field($model, 'indeksSaranaPenunjang')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-indekssaranapenunjang'])->label('Indeks Kinerja Sistem Irigasi Permukaan - Sarana Penunjang (Nilai Maks 10%)') ?>

    <?= $form->field($model, 'indeksOrganisasiPersonalia')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-indeksorganisasipersonalia'])->label('Indeks Kinerja Sistem Irigasi Permukaan - Organisasi Personalia (Nilai Maks 10%)') ?>

    <?= $form->field($model, 'indeksDokumentasi')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-indeksdokumentasi'])->label('Indeks Kinerja Sistem Irigasi Permukaan - Dokumetasi (Nilai Maks 5%)') ?>

    <?= $form->field($model, 'indeksPpa')->textInput(['maxlength' => true, 'id' => 'irigasisaluran-indeksppa'])->label('Indeks Kinerja Sistem Irigasi Permukaan - P3A/GP3A/IP3A (Nilai Maks 10%)') ?>

    <?= $form->field($model, 'indeksJumlah')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'irigasisaluran-indeksjumlah'])->label('Indeks Kinerja Sistem Irigasi Permukaan - Jumlag (Nilai Maks 100%)') ?>

    <?= $form->field($model, 'indeksKategori')->textarea(['rows' => 6, 'id' => 'irigasisaluran-indekskategori', 'readonly' => true])->label('Indeks Kinerja Sistem Irigasi Permukaan - Kategori (SB/B/K/J)') ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kodeTahun')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\TahunIrigasi::find()->all(), 'tahun', 'tahun'),
        ['prompt' => 'Pilih Tahun']
    )->label('Tahun') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>