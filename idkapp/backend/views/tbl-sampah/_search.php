<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\TblSampahSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-sampah-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'no') ?>

    <?= $form->field($model, 'enumerator') ?>

    <?= $form->field($model, 'fasilitas') ?>

    <?= $form->field($model, 'lokasi') ?>

    <?php // echo $form->field($model, 'kondisi') ?>

    <?php // echo $form->field($model, 'thn_pembangunan') ?>

    <?php // echo $form->field($model, 'thn_optimalisasi') ?>

    <?php // echo $form->field($model, 'kegiatan_pengurangan') ?>

    <?php // echo $form->field($model, 'jlh_sampah_masuk') ?>

    <?php // echo $form->field($model, 'jlh_sampah_terolah') ?>

    <?php // echo $form->field($model, 'jlh_sampah_residu') ?>

    <?php // echo $form->field($model, 'pengelola') ?>

    <?php // echo $form->field($model, 'nama_lembaga') ?>

    <?php // echo $form->field($model, 'bentuk_lembaga') ?>

    <?php // echo $form->field($model, 'jlh_anggota') ?>

    <?php // echo $form->field($model, 'kel_bidang') ?>

    <?php // echo $form->field($model, 'wilayah') ?>

    <?php // echo $form->field($model, 'operasional') ?>

    <?php // echo $form->field($model, 'asset') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'latitude') ?>

    <?php // echo $form->field($model, 'longitude') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
