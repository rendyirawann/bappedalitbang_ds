<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Jalan';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Jalan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-jalan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'namaJalan',
                    ],
                ]) ?>



</div>
