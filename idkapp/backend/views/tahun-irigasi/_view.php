<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Tahun Irigasi';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Tahun Irigasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-tahun-irigasi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tahun',
        ],
    ]) ?>


</div>