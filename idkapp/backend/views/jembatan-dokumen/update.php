<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\JembatanDokumen $model */

$this->title = 'Update Jembatan Dokumen: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jembatan Dokumens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jembatan-dokumen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
