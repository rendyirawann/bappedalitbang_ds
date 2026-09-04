<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\JembatanDokumen $model */

$this->title = 'Create Jembatan Dokumen';
$this->params['breadcrumbs'][] = ['label' => 'Jembatan Dokumens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jembatan-dokumen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
