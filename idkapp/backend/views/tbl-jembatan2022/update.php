<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\TblJembatan2022 $model */

$this->title = 'Update Tbl Jembatan2022: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Jembatan2022s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-jembatan2022-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
