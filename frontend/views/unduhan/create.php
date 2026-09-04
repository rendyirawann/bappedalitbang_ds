<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Unduhan $model */

$this->title = 'Create Unduhan';
$this->params['breadcrumbs'][] = ['label' => 'Unduhans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unduhan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
