<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\BeritaAlt $model */

$this->title = 'Update Berita Alt: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Berita Alts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="berita-alt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
