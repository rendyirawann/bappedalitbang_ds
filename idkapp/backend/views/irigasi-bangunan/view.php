<style>
    .modal-xxl {
        max-width: 90%;
        /* You can adjust the percentage as needed */
    }
</style>
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\IrigasiBangunan $model */

$this->title = 'View Data Irigasi Bangunan - ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Irigasi Bangunans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index']) ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= Url::to(['/irigasi-bangunan/index']) ?>">Data Irigasi Bangunan</a></li>
                            <li class="breadcrumb-item" aria-current="page">View Irigasi Bangunan</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">View Irigasi Bangunan</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->


        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ form-element ] start -->
            <div class="col-lg-12">
                <!-- Basic Inputs -->
                <div class="card">
                    <div class="card-body">
                        <h1>View Irigasi Bangunan - <?= Html::encode($model->id) ?></h1>

                        <p>
                            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                            <?= Html::button('<i class="fa fa-plus"></i>', [
                                'class' => 'btn btn-success',
                                'data-bs-toggle' => 'modal',
                                'data-bs-target' => '#createModal',
                            ]) ?>
                        </p>

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'id',
                                [
                                    'attribute' => 'nomeklatur',
                                    'label' => 'Nomeklatur/Nama D.I.',
                                ],
                                [
                                    'attribute' => 'kodeDesa',
                                    'label' => 'Desa',
                                ],
                                [
                                    'attribute' => 'luasIrigasi',
                                    'label' => 'Luas D.I. Sesuai Permen 14/15 (Ha)',
                                ],
                                [
                                    'attribute' => 'bgnUtamaKondisi',
                                    'label' => 'Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Utama Nilai Kondisi (%)',
                                ],
                                [
                                    'attribute' => 'bgnUtamaStatus',
                                    'label' => 'Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Utama Status(B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'bgnPengaturPengukurKondisi',
                                    'label' => 'Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pengatur&Pengukur Nilai Kondisi (%)',
                                ],
                                [
                                    'attribute' => 'bgnPengaturPengukurStatus',
                                    'label' => 'Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pengatur&Pengukur Status(B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'bgnPembawaKondisi',
                                    'label' => 'Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pembawa Nilai Kondisi (%)',
                                ],
                                [
                                    'attribute' => 'bgnPembawaStatus',
                                    'label' => 'Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pembawa Status(B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'bgnLindungKondisi',
                                    'label' => 'Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pelindung Nilai Kondisi (%)',
                                ],
                                [
                                    'attribute' => 'bgnLindungStatus',
                                    'label' => 'Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pelindung Status(B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'bgnPelengkapKondisi',
                                    'label' => 'Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pelengkap Nilai Kondisi (%)',
                                ],
                                [
                                    'attribute' => 'bgnPelengkapStatus',
                                    'label' => 'Kondisi Fisik Bangunan Irigasi Permukaan - Bangunan Pelengkap Status(B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'saranaKondisi',
                                    'label' => 'Kondisi Fisik Bangunan Irigasi Permukaan - Sarana Nilai Kondisi (%)',
                                ],
                                [
                                    'attribute' => 'saranaStatus',
                                    'label' => 'Kondisi Fisik Bangunan Irigasi Permukaan - Sarana Status(B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'rataKondisi',
                                    'label' => 'Rata-Rata Nilai Kondisi (%)',
                                ],
                                [
                                    'attribute' => 'rataStatus',
                                    'label' => 'Rata-Rata Status(B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'keterangan',
                                    'label' => 'Keterangan',
                                ],
                                [
                                    'attribute' => 'kodeTahun',
                                    'label' => 'Tahun',
                                ],
                            ],
                        ]) ?>

                    </div>
                </div>

            </div>
            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xxl">
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
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->

            <!-- [ form-element ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>