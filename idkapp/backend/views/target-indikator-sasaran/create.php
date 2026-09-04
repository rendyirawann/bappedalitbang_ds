<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\TargetIndikatorSasaran $model */

$this->title = 'Create Target Indikator Sasaran';
$this->params['breadcrumbs'][] = ['label' => 'Target Indikator Sasarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="target-indikator-sasaran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
