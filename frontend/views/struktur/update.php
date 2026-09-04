<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Struktur $model */

$this->title = 'Update Struktur: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Strukturs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="struktur-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
