<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\KeteranganJembatan $model */

$this->title = 'Create Keterangan Jembatan';
$this->params['breadcrumbs'][] = ['label' => 'Keterangan Jembatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="keterangan-jembatan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
