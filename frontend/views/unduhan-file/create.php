<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\UnduhanFile $model */

$this->title = 'Create Unduhan File';
$this->params['breadcrumbs'][] = ['label' => 'Unduhan Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unduhan-file-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
