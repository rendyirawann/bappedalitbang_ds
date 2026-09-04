<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\DataIpaldSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="data-ipald-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'enumerator') ?>

    <?= $form->field($model, 'fasilitas') ?>

    <?= $form->field($model, 'kodeKecamatan') ?>

    <?= $form->field($model, 'kodeDesa') ?>

    <?php // echo $form->field($model, 'alamat') ?>

    <?php // echo $form->field($model, 'tahunPembangunan') ?>

    <?php // echo $form->field($model, 'tahunRehabilitasi') ?>

    <?php // echo $form->field($model, 'kapasitasDesain') ?>

    <?php // echo $form->field($model, 'kapasitasPakai') ?>

    <?php // echo $form->field($model, 'sistem') ?>

    <?php // echo $form->field($model, 'kondisi') ?>

    <?php // echo $form->field($model, 'kodePengelola') ?>

    <?php // echo $form->field($model, 'cekEffluent') ?>

    <?php // echo $form->field($model, 'namaLembaga') ?>

    <?php // echo $form->field($model, 'bentukLembaga') ?>

    <?php // echo $form->field($model, 'jumlahAnggota') ?>

    <?php // echo $form->field($model, 'kodeBidang') ?>

    <?php // echo $form->field($model, 'kodeDana') ?>

    <?php // echo $form->field($model, 'kodeAset') ?>

    <?php // echo $form->field($model, 'kodeStatus') ?>

    <?php // echo $form->field($model, 'latitude') ?>

    <?php // echo $form->field($model, 'longitude') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
