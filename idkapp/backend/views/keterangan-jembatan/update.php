<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\KeteranganJembatan $model */

$this->title = 'Update Keterangan Jembatan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Keterangan Jembatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="keterangan-jembatan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
