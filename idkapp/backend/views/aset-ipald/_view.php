<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Aset IPALD';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Aset IPALD', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aset-ipald-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'namaAset:ntext',
        ],
    ]) ?>


</div>
