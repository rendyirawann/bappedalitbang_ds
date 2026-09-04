<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\DanaSepticIndividu $model */

$this->title = 'Update Dana Septic Individu: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dana Septic Individus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dana-septic-individu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
