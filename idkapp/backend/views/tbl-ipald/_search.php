<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\TblIpaldSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-ipald-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'no') ?>

    <?= $form->field($model, 'enumerator') ?>

    <?= $form->field($model, 'fasilitas') ?>

    <?= $form->field($model, 'wilayah') ?>

    <?php // echo $form->field($model, 'thn_pembangunan') ?>

    <?php // echo $form->field($model, 'thn_rehabilitasi') ?>

    <?php // echo $form->field($model, 'kapasitas_desain') ?>

    <?php // echo $form->field($model, 'kapasitas_pakai') ?>

    <?php // echo $form->field($model, 'sistem') ?>

    <?php // echo $form->field($model, 'kondisi') ?>

    <?php // echo $form->field($model, 'pengelola') ?>

    <?php // echo $form->field($model, 'pengecekan') ?>

    <?php // echo $form->field($model, 'nama_lembaga') ?>

    <?php // echo $form->field($model, 'bentuk_lembaga') ?>

    <?php // echo $form->field($model, 'jlh_anggota') ?>

    <?php // echo $form->field($model, 'kel_bidang') ?>

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
