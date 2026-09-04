<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Visimisi $model */

$this->title = 'Create Visimisi';
$this->params['breadcrumbs'][] = ['label' => 'Visimisis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visimisi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
