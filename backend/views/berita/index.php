<?php

use backend\models\Berita;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\BeritaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Berita';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= Url::to(['/site/index']) ?>">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Berita Perencanaan</li>
      </ol>
		<!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Data Berita Perencanaan</div>
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
          <?php
                    $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
                    if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
                      ?>
        <p>
        <?= Html::a('Tambah Berita', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php } ?>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Berita</th>
                  <th>Bidang</th>
                  <th>Tanggal Berita</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Berita</th>
                  <th>Bidang</th>
                  <th>Tanggal Berita</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
              <?php $no = 1; ?>
              <?php foreach ($dataProvider->models as $model): ?>
                <tr>
                    <td><?= Html::encode($no++) ?></td>
                    <td><?= Html::encode($model->judulBerita) ?></td>
                    <td><?= Html::encode($model->bidang->bidang) ?></td>
                    <td><?= Html::encode($model->tgl_berita) ?></td>
                    <td>
                        <?php
                        if ($model->status == 0) {
                            echo '<i class="fa fa-hourglass-half" style="color: orange;"> Review</i>';
                        } elseif ($model->status == 1) {
                            echo '<i class="fa fa-check" style="color: green;"> Berita Publish</i>';
                        } elseif ($model->status == 2) {
                            echo '<i class="fa fa-times-circle" style="color: red;"> Berita Ditolak</i>';
                        } else {
                            // Handle kondisi lain jika diperlukan
                            echo 'Status tidak valid';
                        }
                        ?>
                        </td>
                    <td style="width: 150px;">
                    <button type="button" class="btn btn-primary btn-sm" title="View" data-toggle="modal" data-target="#myModal<?= $model->id ?>">
                                <i class="fa fa-info"></i>
                            </button>
                            <?= Html::a('<i class="fa fa-eye"></i>', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm', 'title' => 'View']) ?>
                            <?= Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-success btn-sm', 'title' => 'Update']) ?>
                            <?php
                    $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
                    if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
                      ?>
                            <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger btn-sm',
                                'title' => 'Delete',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                            <?php } ?>
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
                    <h5 class="modal-title" id="exampleModalLabel">Detail Berita</h5>
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
                    <?php
                    $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
                    if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
                      ?>
                    <?= Html::a('Tambah Gambar Berita', ['berita-alt/create', 'berita_id' => $model->id], ['class' => 'btn btn-success']) ?>
                    <?php } ?>
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
