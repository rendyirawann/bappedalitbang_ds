<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Tahapan $model */

$this->title = 'Update Tahapan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tahapans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php
use yii\helpers\Url;
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= Url::to(['/site/index']) ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= Url::to(['/tahapan/index']) ?>">Tahapan Perencanaan</a>
            </li>
            <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
        </ol>
        
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-edit"></i> <?= Html::encode($this->title) ?>
            </div>
            <div class="card-body">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
