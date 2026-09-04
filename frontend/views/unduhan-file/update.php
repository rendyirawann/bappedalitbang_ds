<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\UnduhanFile $model */

$this->title = 'Update Unduhan File: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Unduhan Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="unduhan-file-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
