<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Status Aset';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Status Aset', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-aset-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'namaStatus:ntext',
                    ],
                ]) ?>


</div>
