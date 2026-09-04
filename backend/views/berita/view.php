<?php

use coderius\lightbox2\Lightbox2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\models\Berita;
use backend\models\BeritaAlt;

/** @var yii\web\View $this */
/** @var backend\models\Berita $model */

$this->title = $model->judulBerita;
$this->params['breadcrumbs'][] = ['label' => 'Beritas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
echo Lightbox2::widget([
    'clientOptions' => [
        'resizeDuration' => 200,
        'wrapAround' => true,
    ],
]);
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= Url::to(['/site/index']) ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= Url::to(['/berita/index']) ?>">Berita Perencanaan</a>
            </li>
            <li class="breadcrumb-item active">View Berita Perencanaan</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <h1>Detail Berita - <?= Html::encode($this->title) ?></h1>
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
                    <?= Html::a('Preview', ['preview', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php
                    $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
                    if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
                    ?>

                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
                        <?= Html::a('<i class="fa fa-download"></i>', ['download', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                    <?php } ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'file',
                            'format' => 'html',
                            'value' => function ($model) {
                                return Html::img('@web/uploads/berita/' . $model->file, ['width' => '600px']);
                            },
                        ],
                        'judulBerita:ntext',
                        [
                            'attribute' => 'isiBerita',
                            'format' => 'raw', // Allows rendering HTML
                            'label' => 'Isi Berita', // Ganti label di sini
                            'value' => function ($model) {
                                return $model->isiBerita;
                            },
                        ],
                        [
                            'attribute' => 'bidang_id',
                            'label' => 'Berita Bidang', // Ganti label di sini
                            'value' => function ($model) {
                                return $model->bidang->bidang;
                            },
                        ],
                        'tgl_berita:date',
                        'keterangan:ntext',
                        [
                            'attribute' => 'status',
                            'format' => 'raw', // Allows rendering HTML
                            'value' => function ($model) {
                                if ($model->status === 0) {
                                    return '<i class="fa fa-hourglass-half" style="color: orange;"> Review Berita</i>';
                                } elseif ($model->status === 1) {
                                    return '<i class="fa fa-check" style="color: green;"> Berita Publish</i>';
                                } elseif ($model->status === 2) {
                                    return '<i class="fa fa-times-circle" style="color: red;"> Berita di Tolak</i>';
                                } else {
                                    // Handle other status values if needed
                                    return Html::encode($model->status);
                                }
                            },
                        ],
                    ],
                ]) ?>

                <?php
                // Mengambil semua BeritaAlt yang memiliki berita_id sesuai dengan id berita saat ini
                $beritaAlts = \backend\models\BeritaAlt::find()
                    ->where(['berita_id' => $model->id])
                    ->all();
                ?>

                <?php if (!empty($beritaAlts)): ?>
                    <h2>Gambar Tambahan</h2>
                    <div class="row">
                        <?php foreach ($beritaAlts as $beritaAlt): ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <div class="thumbnail">
                                    <?= Html::a(
                                        Html::img('@web/uploads/berita_alt/' . $beritaAlt->file, [
                                            'style' => 'width: 100%; height: 200px; object-fit: cover;'
                                        ]),
                                        '@web/uploads/berita_alt/' . $beritaAlt->file,
                                        ['data-lightbox' => 'berita-alt', 'data-title' => $model->judulBerita]
                                    )
                                    ?>
                                    <?php
                                    $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
                                    if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
                                    ?>

                                        <?= Html::a(
                                            '<i class="fa fa-download"></i>',
                                            ['berita-alt/download', 'id' => $beritaAlt->id],
                                            [
                                                'class' => 'btn btn-success btn-sm mr-2',
                                                'title' => 'Download',
                                            ]
                                        ) ?>
                                        <?= Html::a('<i class="fa fa-trash"></i>', ['berita-alt/delete', 'id' => $beritaAlt->id], [
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
                    <p>Tidak ada Gambar Tambahan untuk Berita Perencanaan ini</p>
                <?php endif; ?>
                <?php
                $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
                if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
                ?>

                    <?= Html::a('Tambah Gambar Berita', ['berita-alt/create', 'berita_id' => $model->id], ['class' => 'btn btn-success mt-3']) ?>
                <?php } ?>
            </div>
        </div>

    </div>
    <!-- /tables-->
</div>
<!-- /container-fluid-->
</div>
<!-- /container-wrapper-->