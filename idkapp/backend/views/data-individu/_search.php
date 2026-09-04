<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\DataIndividuSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="data-individu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'koderef_kegiatan') ?>

    <?= $form->field($model, 'ref_kegiatan') ?>

    <?= $form->field($model, 'koderef_subkegiatan') ?>

    <?= $form->field($model, 'ref_subkegiatan') ?>

    <?= $form->field($model, 'kodeRekening') ?>

    <?= $form->field($model, 'namaKegiatan') ?>

    <?= $form->field($model, 'kodeTahun') ?>

    <?php // echo $form->field($model, 'kodeDesa') 
    ?>

    <?php // echo $form->field($model, 'kodeKecamatan') 
    ?>

    <?php // echo $form->field($model, 'alamat') 
    ?>

    <?php // echo $form->field($model, 'satuan') 
    ?>

    <?php // echo $form->field($model, 'jumlah') 
    ?>

    <?php // echo $form->field($model, 'harga') 
    ?>

    <?php // echo $form->field($model, 'kodeDana') 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>