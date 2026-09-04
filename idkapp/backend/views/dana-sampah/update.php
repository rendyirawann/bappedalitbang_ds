<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\DanaSampah $model */

$this->title = 'Update Dana Sampah: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dana Sampahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dana-sampah-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
