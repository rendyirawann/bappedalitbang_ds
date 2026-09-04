<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\AsetSampah $model */

$this->title = 'Create Aset Sampah';
$this->params['breadcrumbs'][] = ['label' => 'Aset Sampahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aset-sampah-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
