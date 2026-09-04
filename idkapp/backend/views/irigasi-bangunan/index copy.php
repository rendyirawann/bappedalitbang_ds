<?php

use backend\models\IrigasiBangunan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\IrigasiBangunanSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Irigasi Bangunans';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
    $('#createModal').on('show.bs.modal', function (event) {
        var modal = $(this);
        $.ajax({
            url: '" . Url::to(['irigasi-bangunan/create']) . "',
            type: 'GET',
            success: function(data) {
                modal.find('#modalFormContent').html(data);
            }
        });
    });
");
?>
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index']) ?>">Homee</a></li>
                            <li class="breadcrumb-item" aria-current="page">Data Irigasi Bangunan</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Data Irigasi Bangunan</h2>
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
                        <h5>Data Irigasi Bangunan</h5>
                        <small>List Data</small>
                    </div>
                    <div class="card-body">
                        <?php if (Yii::$app->session->hasFlash('success')) : ?>
                            <div class="alert alert-success">
                                <?= Yii::$app->session->getFlash('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (Yii::$app->session->hasFlash('error')) : ?>
                            <div class="alert alert-danger">
                                <?= Yii::$app->session->getFlash('error') ?>
                            </div>
                        <?php endif; ?>
                        <?= Html::button('Tambah Data Irigasi Bangunan', [
                            'class' => 'btn btn-success',
                            'data-bs-toggle' => 'modal',
                            'data-bs-target' => '#createModal',
                        ]) ?>
                        <!-- <?= Html::a('Upload CSV to Database', ['upload'], ['class' => 'btn btn-success']) ?> -->
                        <div class="dt-responsive table-responsive mt-2">
                            <table id="table-style-hover" class="table table-striped table-hover table-bordered nowrap" style="font-size:medium;">
                                <thead>
                                    <tr>
                                        <th rowspan="4">No</th>
                                        <th rowspan="4">Nomeklatur</th>
                                        <th rowspan="4">Desa</th>
                                        <th rowspan="4">Luas</th>
                                        <th colspan="12" style="text-align: center;">Kondisi Fisik Bangunan Irigasi Permukaan</th>
                                        <th colspan="2" rowspan="2">Rata-Rata Kondisi Bangunan</th>
                                        <th rowspan="4">Keterangan</th>
                                        <th rowspan="4">Action</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Bangunan Utama</th>
                                        <th colspan="2">Bangunan Pengatur dan Pengukur</th>
                                        <th colspan="2">Bangunan Pembawa</th>
                                        <th colspan="2">Bangunan Lindung</th>
                                        <th colspan="2">Bangunan Pelengkap</th>
                                        <th colspan="2">Sarana</th>
                                    </tr>
                                    <tr>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $no = 1; ?>
                                    <?php foreach ($dataProvider->models as $model) : ?>
                                        <tr>
                                            <td><?= Html::encode($no++) ?></td>
                                            <td><?= Html::encode($model->nomeklatur) ?></td>
                                            <td><?= Html::encode($model->kodeDesa) ?></td>
                                            <td><?= Html::encode($model->luasIrigasi) ?> Ha</td>
                                            <td><?= Html::encode($model->bgnUtamaStatus) ?></td>
                                            <td><?= Html::encode($model->bgnUtamaKondisi) ?> %</td>
                                            <td><?= Html::encode($model->bgnPengaturPengukurStatus) ?></td>
                                            <td><?= Html::encode($model->bgnPengaturPengukurKondisi) ?> %</td>
                                            <td><?= Html::encode($model->bgnPengaturPengukurStatus) ?></td>
                                            <td><?= Html::encode($model->bgnPengaturPengukurKondisi) ?> %</td>
                                            <td><?= Html::encode($model->bgnLindungStatus) ?></td>
                                            <td><?= Html::encode($model->bgnLindungKondisi) ?> %</td>
                                            <td><?= Html::encode($model->bgnPelengkapStatus) ?></td>
                                            <td><?= Html::encode($model->bgnPelengkapKondisi) ?> %</td>
                                            <td><?= Html::encode($model->saranaStatus) ?></td>
                                            <td><?= Html::encode($model->saranaKondisi) ?> %</td>
                                            <td><?= Html::encode($model->rataStatus) ?></td>
                                            <td><?= Html::encode($model->rataKondisi) ?> %</td>
                                            <td><?= Html::encode($model->keterangan) ?></td>
                                            <td style=" width: 150px;">
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
                                        <th rowspan="4">No</th>
                                        <th rowspan="4">Nomeklatur</th>
                                        <th rowspan="4">Desa</th>
                                        <th rowspan="4">Luas</th>
                                        <th colspan="12" style="text-align: center;">Kondisi Fisik Bangunan Irigasi Permukaan</th>
                                        <th colspan="2" rowspan="2">Rata-Rata Kondisi Bangunan</th>
                                        <th rowspan="4">Keterangan</th>
                                        <th rowspan="4">Action</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Bangunan Utama</th>
                                        <th colspan="2">Bangunan Pengatur dan Pengukur</th>
                                        <th colspan="2">Bangunan Pembawa</th>
                                        <th colspan="2">Bangunan Lindung</th>
                                        <th colspan="2">Bangunan Pelengkap</th>
                                        <th colspan="2">Sarana</th>
                                    </tr>
                                    <tr>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                        <th>B/RR/RS/RB</th>
                                        <th>Nilai Kondisi (%)</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- Modal -->
                        <?php foreach ($dataProvider->models as $model) : ?>
                            <div class="modal fade" id="myModal<?= $model->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Detail Data Irigasi Bangunan</h5>
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
                        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createModalLabel">Tambah Data Irigasi Bangunan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- The form will be loaded here -->
                                        <div id="modalFormContent">
                                            <!-- AJAX-loaded content will be injected here -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                    </div>
                </div>
            </div>
            <!-- Base style - Hover table end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>