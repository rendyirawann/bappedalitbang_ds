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
/** @var backend\models\IrigasiSaluran $model */

$this->title = 'View Data Irigasi Saluran - ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Irigasi Salurans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerJs("
    $('#createModal').on('show.bs.modal', function (event) {
        var modal = $(this);
        $.ajax({
            url: '" . Url::to(['irigasi-saluran/create']) . "',
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
                            <li class="breadcrumb-item"><a href="<?= Url::to(['/irigasi-saluran/index']) ?>">Data Irigasi Saluran</a></li>
                            <li class="breadcrumb-item" aria-current="page">View Irigasi Saluran</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">View Irigasi Saluran</h2>
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
                        <h1>View Irigasi Saluran - <?= Html::encode($model->id) ?></h1>

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
                                    'attribute' => 'igt',
                                    'label' => 'Sawah/Fungsional (Pemetaan IGT) (Ha)',
                                ],
                                [
                                    'attribute' => 'primerKondisiBaik',
                                    'label' => 'Saluran Primer - (%) Kondisi Baik',
                                ],
                                [
                                    'attribute' => 'primerSaluranStatus',
                                    'label' => 'Saluran Primer - Status (B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'primerPjgSaluran',
                                    'label' => 'Saluran Primer - Total Panjang Saluran (m)',
                                ],
                                [
                                    'attribute' => 'primerSaluranBaik',
                                    'label' => 'Saluran Primer - Saluran Kondisi Baik (m)',
                                ],
                                [
                                    'attribute' => 'sekunderKondisiBaik',
                                    'label' => 'Saluran Sekunder - (%) Kondisi Baik',
                                ],
                                [
                                    'attribute' => 'sekunderSaluranStatus',
                                    'label' => 'Saluran Sekunder - Status (B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'sekunderPjgSaluran',
                                    'label' => 'Saluran Sekunder - Total Panjang Saluran (m)',
                                ],
                                [
                                    'attribute' => 'sekunderSaluranBaik',
                                    'label' => 'Saluran Sekunder - Saluran Kondisi Baik (m)',
                                ],
                                [
                                    'attribute' => 'pembuangKondisiBaik',
                                    'label' => 'Saluran Pembuang - (%) Kondisi Baik',
                                ],
                                [
                                    'attribute' => 'pembuangSaluranStatus',
                                    'label' => 'Saluran Pembuang - Status (B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'bangunanBagiKondisiBaik',
                                    'label' => 'Bangunan Bagi - (%) Kondisi Baik',
                                ],
                                [
                                    'attribute' => 'bangunanBagiStatus',
                                    'label' => 'Bangunan Bagi - Status (B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'bangunanBagiSadapKondisiBaik',
                                    'label' => 'Bangunan Bagi Sadap - (%) Kondisi Baik',
                                ],
                                [
                                    'attribute' => 'bangunanBagiSadapStatus',
                                    'label' => 'Bangunan Bagi Sadap - Status (B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'bangunanSadapKondisiBaik',
                                    'label' => 'Bangunan Sadap - (%) Kondisi Baik',
                                ],
                                [
                                    'attribute' => 'bangunanSadapStatus',
                                    'label' => 'Bangunan Sadap - Status (B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'bangunanPintuAirKondisiBaik',
                                    'label' => 'Bangunan Pintu Air - (%) Kondisi Baik',
                                ],
                                [
                                    'attribute' => 'bangunanPintuAirStatus',
                                    'label' => 'Bangunan Pintu Air - Status (B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'bangunanTalangKondisiBaik',
                                    'label' => 'Bangunan Talang - (%) Kondisi Baik',
                                ],
                                [
                                    'attribute' => 'bangunanTalangStatus',
                                    'label' => 'Bangunan Talang - Status (B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'bangunanSiponKondisiBaik',
                                    'label' => 'Bangunan Sipon - (%) Kondisi Baik',
                                ],
                                [
                                    'attribute' => 'bangunanSiponStatus',
                                    'label' => 'Bangunan Sipon - Status (B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'bangunanGorongKondisiBaik',
                                    'label' => 'Bangunan Gorong - (%) Kondisi Baik',
                                ],
                                [
                                    'attribute' => 'bangunanGorongStatus',
                                    'label' => 'Bangunan Gorong - Status (B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'bangunanTerjunKondisiBaik',
                                    'label' => 'Bangunan Terjun - (%) Kondisi Baik',
                                ],
                                [
                                    'attribute' => 'bangunanTerjunStatus',
                                    'label' => 'Bangunan Terjun - Status (B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'bangunanTanggulKondisiBaik',
                                    'label' => 'Bangunan Tanggul - (%) Kondisi Baik',
                                ],
                                [
                                    'attribute' => 'bangunanTanggulStatus',
                                    'label' => 'Bangunan Tanggul - Status (B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'rataJaringanKondisiBaik',
                                    'label' => 'Rata-rata Jaringan - (%) Kondisi Baik',
                                ],
                                [
                                    'attribute' => 'rataJaringanStatus',
                                    'label' => 'Rata-rata Jaringan - Status (B/RR/RS/RB)',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'arealBaik',
                                    'label' => 'Areal Baik (Ha)',
                                ],
                                [
                                    'attribute' => 'arealRusakRingan',
                                    'label' => 'Areal Rusak Ringan (Ha)',
                                ],
                                [
                                    'attribute' => 'arealRusakSedang',
                                    'label' => 'Areal Rusak Sedang (Ha)',
                                ],
                                [
                                    'attribute' => 'arealRusakBerat',
                                    'label' => 'Areal Rusak Berat (Ha)',
                                ],
                                [
                                    'attribute' => 'arealTotal',
                                    'label' => 'Total Areal (Ha)',
                                ],
                                [
                                    'attribute' => 'indeksPrasaranaFisik',
                                    'label' => 'Indeks Prasarana Fisik',
                                ],
                                [
                                    'attribute' => 'indeksProduktivitas',
                                    'label' => 'Indeks Produktivitas',
                                ],
                                [
                                    'attribute' => 'indeksSaranaPenunjang',
                                    'label' => 'Indeks Sarana Penunjang',
                                ],
                                [
                                    'attribute' => 'indeksOrganisasiPersonalia',
                                    'label' => 'Indeks Organisasi Personalia',
                                ],
                                [
                                    'attribute' => 'indeksDokumentasi',
                                    'label' => 'Indeks Dokumentasi',
                                ],
                                [
                                    'attribute' => 'indeksPpa',
                                    'label' => 'Indeks PPA',
                                ],
                                [
                                    'attribute' => 'indeksJumlah',
                                    'label' => 'Indeks Jumlah',
                                ],
                                [
                                    'attribute' => 'indeksKategori',
                                    'label' => 'Indeks Kategori',
                                    'format' => 'ntext',
                                ],
                                [
                                    'attribute' => 'keterangan',
                                    'label' => 'Keterangan',
                                    'format' => 'ntext',
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
                            <h5 class="modal-title" id="createModalLabel">Tambah Data Irigasi Saluran</h5>
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