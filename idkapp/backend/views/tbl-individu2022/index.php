<?php

use backend\models\TblIndividu2022;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\TblIndividu2022Search $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Individu 2022';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-container">
      <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
          <div class="page-block">
            <div class="row align-items-center">
              <div class="col-md-12">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="../dashboard/index.html">Homee</a></li>
                  <li class="breadcrumb-item"><a href="javascript: void(0)">DataTable</a></li>
                  <li class="breadcrumb-item" aria-current="page">DataTable Styling</li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="page-header-title">
                  <h2 class="mb-0">DataTable Styling</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ breadcrumb ] end -->


        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- Base style - Hover table start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h5>Base Style - Hover</h5>
                <small
                  >This example shows DataTables with just the hover class specified. This class instructs DataTables' styling to highlight
                  a row when the mouse is hovered over it.</small
                >
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
            <?= Html::a('Create Tbl Individu 2022', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Upload CSV to Database', ['upload'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Export to CSV', ['export-csv'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Export to XLSX', ['export-xlsx'], ['class' => 'btn btn-primary']) ?>
                <div class="dt-responsive table-responsive">
                  <table id="table-style-hover" class="table table-striped table-hover table-bordered nowrap">
                    <thead>
                    <tr>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
                    <th>Desa</th>
                    <th>Kecamatan</th>
                    <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    <?php $no = 1; ?>
                      <?php foreach ($dataProvider->models as $model): ?>
                      <tr>
                        <td><?= Html::encode($no++) ?></td>
                        <td><?= Html::encode($model->namaKegiatan) ?></td>
                        <td><?= Html::encode($model->desa) ?></td>
                        <td><?= Html::encode($model->kecamatan) ?></td>
                        <td style="width: 150px;">
                      <button type="button" class="btn btn-primary btn-sm" title="View" data-bs-toggle="modal" data-bs-target="#myModal<?= $model->id ?>">
                                  <i class="fas fa-eye"></i>
                              </button>
                              <?= Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-success btn-sm', 'title' => 'Update']) ?>
                              <?= Html::a('<i class="fas fa-trash-alt"></i>', ['delete', 'id' => $model->id], [
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
                    <tfoot>
                    <tr>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
                    <th>Desa</th>
                    <th>Kecamatan</th>
                    <th>Action</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                                <!-- Modal -->
<?php foreach ($dataProvider->models as $model): ?>
    <div class="modal fade" id="myModal<?= $model->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Data Individu 2022</h5>
                </div>
                <div class="modal-body">
                    <!-- Render view.php di sini -->
                    <?= $this->render('_view', ['model' => $model]) ?>
                </div>
                <div class="modal-footer">
                <?= Html::a('<i class="fas fa-eye"> </i>', ['view', 'id' => $model->id], ['class' => 'btn btn-info ml-2', 'title' => 'View']) ?>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
              </div>
            </div>
          </div>
          <!-- Base style - Hover table end -->
        </div>
        <!-- [ Main Content ] end -->
      </div>
    </div>
