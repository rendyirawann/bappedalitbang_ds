<?php

use backend\models\Tahapan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tahapans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= Url::to(['/site/index']) ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
        </ol>
        
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> Data Tahapan Perencanaan
            </div>
            <div class="card-body">
                <p>
                    <?= Html::a('Tambah Tahapan', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Tahapan</th>
                                <th>Tahun</th>
                                <th>Jumlah Tahapan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($dataProvider->models as $model): ?>
                                <tr>
                                    <td><?= Html::encode($no++) ?></td>
                                    <td><?= Html::encode($model->judul_tahapan) ?></td>
                                    <td><?= Html::encode($model->tahun) ?></td>
                                    <td><?= Html::encode(count($model->tahapanItems)) ?></td>
                                    <td style="width: 150px;">
                                        <?= Html::a('<i class="fa fa-eye"></i>', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm', 'title' => 'View']) ?>
                                        <?= Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-success btn-sm', 'title' => 'Update']) ?>
                                        <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
                                            'class' => 'btn btn-danger btn-sm',
                                            'title' => 'Delete',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer small text-muted">Data Table</div>
        </div>
    </div>
</div>
