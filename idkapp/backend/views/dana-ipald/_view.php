<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Sumber Dana IPALD';
$this->params['breadcrumbs'][] = ['label' => 'Detail Sumber Dana IPALD', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dana-ipald-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'sumberDana:ntext',
                    ],
                ]) ?>


</div>
