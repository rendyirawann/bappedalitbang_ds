<?php

use backend\models\Profil;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\ProfilSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Berkas Profil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= Url::to(['/site/index']) ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Berkas Profil</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> Data Berkas Profil
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
                    <?= Html::a('Tambah Berkas Profil', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Tanggal Upload</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Tanggal Upload</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($dataProvider->models as $model): ?>
                                <tr>
                                    <td><?= Html::encode($no++) ?></td>
                                    <td><?= Html::encode($model->namaFile) ?></td>
                                    <td><?= Html::encode($model->tanggalUpload) ?></td>
                                    <td style="width: 150px;">
                                        <button type="button" class="btn btn-primary btn-sm" title="View" data-toggle="modal" data-target="#myModal<?= $model->id ?>">
                                            <i class="fa fa-info"></i>
                                        </button>
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
                    <!-- Modal -->
                    <?php foreach ($dataProvider->models as $model): ?>
                        <div class="modal fade" id="myModal<?= $model->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Detail Berkas</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Render view.php di sini -->
                                        <?= $this->render('_view', ['model' => $model]) ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card-footer small text-muted">Data Table</div>
        </div>
        <!-- /tables-->
    </div>
    <!-- /container-fluid-->
</div>