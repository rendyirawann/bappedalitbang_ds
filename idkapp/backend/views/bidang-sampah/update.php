<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\BidangSampah $model */

$this->title = 'Update Bidang Sampah: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bidang Sampahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bidang-sampah-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
