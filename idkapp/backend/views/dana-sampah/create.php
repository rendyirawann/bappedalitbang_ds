<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\DanaSampah $model */

$this->title = 'Create Dana Sampah';
$this->params['breadcrumbs'][] = ['label' => 'Dana Sampahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dana-sampah-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
