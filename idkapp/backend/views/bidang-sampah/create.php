<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\BidangSampah $model */

$this->title = 'Create Bidang Sampah';
$this->params['breadcrumbs'][] = ['label' => 'Bidang Sampahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bidang-sampah-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
