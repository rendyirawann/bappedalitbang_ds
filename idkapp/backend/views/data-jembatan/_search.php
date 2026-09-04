<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\DataJembatanSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="data-jembatan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'namaPekerjaan') ?>

    <?= $form->field($model, 'kodeDesa') ?>

    <?= $form->field($model, 'kodeKecamatan') ?>

    <?= $form->field($model, 'alamat') ?>

    <?php // echo $form->field($model, 'penyedia') ?>

    <?php // echo $form->field($model, 'nilaiPagu') ?>

    <?php // echo $form->field($model, 'nilaiKontrak') ?>

    <?php // echo $form->field($model, 'nilaiAddendum') ?>

    <?php // echo $form->field($model, 'nomorSpmk') ?>

    <?php // echo $form->field($model, 'nomorKontrak') ?>

    <?php // echo $form->field($model, 'nomorAddendum') ?>

    <?php // echo $form->field($model, 'nomorPho') ?>

    <?php // echo $form->field($model, 'realisasiPanjang') ?>

    <?php // echo $form->field($model, 'realisasiLebar') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'tahun') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
