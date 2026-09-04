<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Bidang yang Kelola IPALD';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Bidang yang Kelola IPALD', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bidang-ipald-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'namaBidang:ntext',
                    ],
                ]) ?>


</div>
