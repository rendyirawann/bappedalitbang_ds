<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Unduhan $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Berkas Unduhan', 'url' => ['index']];
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
                <a href="<?= Url::to(['/unduhan/index']) ?>">Berkas Unduhan</a>
            </li>
            <li class="breadcrumb-item active">View Berkas Unduhan</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <h1>Detail Berkas Unduhan</h1>
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

                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'namaFile:ntext',
                        [
                            'attribute' => 'refbidang_id',
                            'label' => 'Berkas Bidang',
                            'value' => function ($model) {
                                return $model->bidang ? $model->bidang->bidang : 'Tidak ada bidang';
                            },
                        ],

                    ],
                ]) ?>


            </div>

        </div>
        <!-- /tables-->
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-lg-12">
                        <?php
                        // Mengambil semua BeritaAlt yang memiliki berita_id sesuai dengan id berita saat ini
                        $unduhanFiles = \backend\models\UnduhanFile::find()
                            ->where(['refunduhan_id' => $model->id])
                            ->all();
                        ?>

                        <?php if (!empty($unduhanFiles)): ?>
                            <h2>Berkas File</h2>
                            <div class="row">
                                <?php foreach ($unduhanFiles as $unduhanFile): ?>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        <div class="thumbnail">
                                            <?php

                                            $filePath = '@web/uploads/unduhan/' . $unduhanFile->file;
                                            $fileUrl = Url::to('@web/uploads/unduhan/' . $unduhanFile->file); // URL untuk link
                                            $fileExtension = strtolower(pathinfo($unduhanFile->file, PATHINFO_EXTENSION));

                                            // Ganti dengan URL CDN ikon PDF yang Anda pilih
                                            $pdfIconCdnUrl = 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/1200px-PDF_file_icon.svg.png'; // Contoh URL

                                            if ($fileExtension === 'pdf') {
                                                // Tampilkan ikon PDF dari CDN jika file adalah PDF
                                                echo Html::a(
                                                    Html::img($pdfIconCdnUrl, [ // Path ke ikon PDF dari CDN
                                                        'alt' => 'PDF Icon',
                                                        'style' => 'width: 100%; height: 200px; object-fit: contain;' // Sesuaikan style jika perlu
                                                    ]),
                                                    $fileUrl, // Link tetap ke file asli
                                                    ['target' => '_blank'] // Buka di tab baru jika diinginkan
                                                );
                                            } else {
                                                // Tampilkan gambar asli jika bukan PDF (atau ikon file generik lainnya)
                                                echo Html::a(
                                                    Html::img(Url::to($filePath), [ // Gunakan Url::to() untuk path lokal juga untuk konsistensi
                                                        'style' => 'width: 100%; height: 200px; object-fit: cover;'
                                                    ]),
                                                    $fileUrl,
                                                    ['target' => '_blank']
                                                );
                                            }
                                            ?>
                                            <div class="caption" style="text-align: center; padding-top: 5px;">
                                                <p title="<?= Html::encode($unduhanFile->file) ?>" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    <?= Html::encode($unduhanFile->file) ?>
                                                </p>
                                            </div>
                                            <?php
                                            $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
                                            if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
                                            ?>
                                                <?= Html::a(
                                                    '<i class="fa fa-download"></i>',
                                                    ['unduhan-file/download', 'id' => $unduhanFile->id],
                                                    [
                                                        'class' => 'btn btn-success btn-sm mr-2',
                                                        'title' => 'Download',
                                                    ]
                                                ) ?>
                                                <?= Html::a('<i class="fa fa-trash"></i>', ['unduhan-file/delete', 'id' => $unduhanFile->id], [
                                                    'class' => 'btn btn-danger btn-sm',
                                                    'title' => 'Delete',
                                                    'data' => [
                                                        'confirm' => 'Are you sure you want to delete this file?',
                                                        'method' => 'post',
                                                    ],
                                                ]) ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p>Tidak ada Berkas untuk File Ini</p>
                        <?php endif; ?>
                        <?php
                        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
                        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
                        ?>

                            <?= Html::a('Tambah Berkas File', ['unduhan-file/create', 'refunduhan_id' => $model->id], ['class' => 'btn btn-success mt-3']) ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /container-fluid-->
</div>
<!-- /container-wrapper-->