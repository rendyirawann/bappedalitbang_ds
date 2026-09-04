<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Struktur $model */

$this->title = 'Create Struktur';
$this->params['breadcrumbs'][] = ['label' => 'Strukturs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="struktur-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
