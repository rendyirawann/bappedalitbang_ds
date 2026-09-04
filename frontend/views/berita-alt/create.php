<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\BeritaAlt $model */

$this->title = 'Create Berita Alt';
$this->params['breadcrumbs'][] = ['label' => 'Berita Alts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="berita-alt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
