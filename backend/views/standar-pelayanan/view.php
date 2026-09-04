<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\StandarPelayanan $model */

$this->title = $model->namaFile . ' - ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Standar Pelayanan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= Url::to(['/site/index']) ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= Url::to(['/standar-pelayanan/index']) ?>">Standar Pelayanan</a>
            </li>
            <li class="breadcrumb-item active">View Standar Pelayanan</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <h1>Detail Standar Pelayanan - <?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-body">
                <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success">
                        <?= Yii::$app->session->getFlash('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (Yii::$app->session->hasFlash('error')): ?>
                    <div class="alert alert-danger">
                        <?= Yii::$app->session->getFlash('error') ?>
                    </div>
                <?php endif; ?>
                <p>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('<i class="fa fa-download"></i>', ['download', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'file',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->isPdf) {
                                    return '<iframe src="' . Url::to('@web/uploads/standar-pelayanan/' . $model->file) . '" width="100%" height="600px" style="border:none;"></iframe>';
                                }
                                return Html::img('@web/uploads/standar-pelayanan/' . $model->file, ['width' => '600px']);
                            },
                        ],
                        'namaFile',
                        'tahun',
                    ],
                ]) ?>
            </div>

        </div>
        <!-- /tables-->
    </div>
    <!-- /container-fluid-->
</div>
<!-- /container-wrapper-->
