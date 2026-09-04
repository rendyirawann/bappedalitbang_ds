<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\DataKpspams $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Kpspams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerJs("
    $('#createModal').on('show.bs.modal', function (event) {
        var modal = $(this);
        $.ajax({
            url: '" . Url::to(['data-kpspams/create']) . "',
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
                            <li class="breadcrumb-item"><a href="<?= Url::to(['/data-kpspams/index']) ?>">Data KPSPAMS</a></li>
                            <li class="breadcrumb-item" aria-current="page">View Data KPSPAMS</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">View Data KPSPAMS</h2>
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
                        <h1>View Data KPSPAMS - <?= Html::encode($model->id) ?></h1>

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
                                'provinsi:ntext',
                                'kabupaten:ntext',
                                [
                                    'attribute' => 'kodeKecamatan',
                                    'label' => 'Nama Kecamatan',
                                    'value' => function ($model) {
                                        return $model->kodeKecamatan0 ? $model->kodeKecamatan0->namaKecamatan : null;
                                    },
                                ],
                                [
                                    'attribute' => 'Nama Desa',
                                    'value' => function ($model) {
                                        return $model->desa ? $model->desa->namaDesa  : null;
                                    },
                                ],
                                [
                                    'label' => 'Kode Desa',
                                    'value' => function ($model) {
                                        return $model->desa ? ' (' . $model->desa->kode . ')' : null;
                                    },
                                ],
                                'namaKades:ntext',
                                'noKades',
                                'namaKpspams:ntext',
                                'noKpspams',
                                [
                                    'attribute' => 'kodeTahun',
                                    'value' => function ($model) {
                                        return $model->kodeTahun0 ? $model->kodeTahun0->tahun : null;
                                    },
                                ],
                            ],
                        ]) ?>







                    </div>
                </div>

            </div>
            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Tambah KPSPAMS</h5>
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