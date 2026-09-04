<?php

use yii\helpers\Html;
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
?>

<div class="data-ipald-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'enumerator')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fasilitas')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kodeKecamatan')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\DataKecamatan::find()->all(), 'namaKecamatan', 'namaKecamatan'),
        ['prompt' => 'Pilih Kecamatan']
    ) ?>

    <?= $form->field($model, 'kodeDesa')->dropDownList(
            \yii\helpers\ArrayHelper::map(\backend\models\DataDesa::find()->all(), 'namaDesa', 'namaDesa'),
            ['prompt' => 'Pilih Desa']
        ) ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tahunPembangunan')->textInput() ?>

    <?= $form->field($model, 'tahunRehabilitasi')->textInput() ?>

    <?= $form->field($model, 'kapasitasDesain')->textInput() ?>

    <?= $form->field($model, 'kapasitasPakai')->textInput() ?>

    <?= $form->field($model, 'sistem')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kondisi')->radioList(array('Rusak'=>'Rusak','Baik'=>'Baik')); ?>

    <?= $form->field($model, 'kodePengelola')->dropDownList(
            \yii\helpers\ArrayHelper::map(\backend\models\DataPengelola::find()->all(), 'namaPengelola', 'namaPengelola'),
            ['prompt' => 'Pilih Pengelola']
        ) ?>

    <?= $form->field($model, 'cekEffluent')->radioList(array('Tidak Dilakukan'=>'Tidak Dilakukan','Dilakukan'=>'Dilakukan')); ?>

    <?= $form->field($model, 'namaLembaga')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bentukLembaga')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jumlahAnggota')->textInput() ?>

    <?= $form->field($model, 'kodeBidang')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\BidangIpald::find()->all(), 'namaBidang', 'namaBidang'),
        ['prompt' => 'Pilih Bidang yang Kelola']
    ) ?>

    <?= $form->field($model, 'kodeDana')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\DanaIpald::find()->all(), 'sumberDana', 'sumberDana'),
        ['prompt' => 'Pilih Sumber Dana']
    ) ?>

    <?= $form->field($model, 'kodeAset')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\AsetIpald::find()->all(), 'namaAset', 'namaAset'),
        ['prompt' => 'Pilih Sumber Dana']
    ) ?>

    <?= $form->field($model, 'kodeStatus')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\StatusAset::find()->all(), 'namaStatus', 'namaStatus'),
        ['prompt' => 'Pilih Sumber Dana']
    ) ?>

    <?= $form->field($model, 'latitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
