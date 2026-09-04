<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\IrigasiSaluran $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="irigasi-saluran-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nomeklatur') ?>

    <?= $form->field($model, 'kodeDesa') ?>

    <?= $form->field($model, 'luasIrigasi') ?>

    <?= $form->field($model, 'igt') ?>

    <?= $form->field($model, 'primerKondisiBaik') ?>

    <?php // echo $form->field($model, 'primerSaluranStatus') 
    ?>

    <?php // echo $form->field($model, 'primerPjgSaluran') 
    ?>

    <?php // echo $form->field($model, 'primerSaluranBaik') 
    ?>

    <?php // echo $form->field($model, 'sekunderKondisiBaik') 
    ?>

    <?php // echo $form->field($model, 'sekunderSaluranStatus') 
    ?>

    <?php // echo $form->field($model, 'sekunderPjgSaluran') 
    ?>

    <?php // echo $form->field($model, 'sekunderSaluranBaik') 
    ?>

    <?php // echo $form->field($model, 'pembuangKondisiBaik') 
    ?>

    <?php // echo $form->field($model, 'pembuangSaluranStatus') 
    ?>

    <?php // echo $form->field($model, 'bangunanBagiKondisiBaik') 
    ?>

    <?php // echo $form->field($model, 'bangunanBagiStatus') 
    ?>

    <?php // echo $form->field($model, 'bangunanBagiSadapKondisiBaik') 
    ?>

    <?php // echo $form->field($model, 'bangunanBagiSadapStatus') 
    ?>

    <?php // echo $form->field($model, 'bangunanSadapKondisiBaik') 
    ?>

    <?php // echo $form->field($model, 'bangunanSadapStatus') 
    ?>

    <?php // echo $form->field($model, 'bangunanPintuAirKondisiBaik') 
    ?>

    <?php // echo $form->field($model, 'bangunanPintuAirStatus') 
    ?>

    <?php // echo $form->field($model, 'bangunanTalangKondisiBaik') 
    ?>

    <?php // echo $form->field($model, 'bangunanTalangStatus') 
    ?>

    <?php // echo $form->field($model, 'bangunanSiponKondisiBaik') 
    ?>

    <?php // echo $form->field($model, 'bangunanSiponStatus') 
    ?>

    <?php // echo $form->field($model, 'bangunanGorongKondisiBaik') 
    ?>

    <?php // echo $form->field($model, 'bangunanGorongStatus') 
    ?>

    <?php // echo $form->field($model, 'bangunanTerjunKondisiBaik') 
    ?>

    <?php // echo $form->field($model, 'bangunanTerjunStatus') 
    ?>

    <?php // echo $form->field($model, 'bangunanTanggulKondisiBaik') 
    ?>

    <?php // echo $form->field($model, 'bangunanTanggulStatus') 
    ?>

    <?php // echo $form->field($model, 'rataJaringanKondisiBaik') 
    ?>

    <?php // echo $form->field($model, 'rataJaringanStatus') 
    ?>

    <?php // echo $form->field($model, 'arealBaik') 
    ?>

    <?php // echo $form->field($model, 'arealRusakRingan') 
    ?>

    <?php // echo $form->field($model, 'arealRusakSedang') 
    ?>

    <?php // echo $form->field($model, 'arealRusakBerat') 
    ?>

    <?php // echo $form->field($model, 'arealTotal') 
    ?>

    <?php // echo $form->field($model, 'indeksPrasaranaFisik') 
    ?>

    <?php // echo $form->field($model, 'indeksProduktivitas') 
    ?>

    <?php // echo $form->field($model, 'indeksSaranaPenunjang') 
    ?>

    <?php // echo $form->field($model, 'indeksOrganisasiPersonalia') 
    ?>

    <?php // echo $form->field($model, 'indeksDokumentasi') 
    ?>

    <?php // echo $form->field($model, 'indeksPpa') 
    ?>

    <?php // echo $form->field($model, 'indeksJumlah') 
    ?>

    <?php // echo $form->field($model, 'indeksKategori') 
    ?>

    <?php // echo $form->field($model, 'keterangan') 
    ?>

    <?php // echo $form->field($model, 'kodeTahun') 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>