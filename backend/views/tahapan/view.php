<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Tahapan $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tahapans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?php
use yii\helpers\Url;
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= Url::to(['/site/index']) ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= Url::to(['/tahapan/index']) ?>">Tahapan Perencanaan</a>
            </li>
            <li class="breadcrumb-item active">View Tahapan</li>
        </ol>
        
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-info-circle"></i> Detail Tahapan Perencanaan
            </div>
            <div class="card-body">
                <p>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'judul_tahapan',
                        'tahun',
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>

                <h5 class="mt-4">Daftar Tahapan Item</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Urutan</th>
                                <th>Nama Tahapan</th>
                                <th>Tanggal</th>
                                <th>Icon Gambar</th>
                                <th>Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model->tahapanItems as $item): ?>
                            <tr>
                                <td><?= Html::encode($item->urutan) ?></td>
                                <td><?= Html::encode($item->nama_tahapan) ?></td>
                                <td><?= Html::encode($item->tanggal) ?></td>
                                <td>
                                    <?php if ($item->icon_gambar): ?>
                                        <img src="<?= Yii::getAlias('@web/../../frontend/web/uploads/tahapan/') . $item->icon_gambar ?>" width="50px">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item->dokumen): ?>
                                        <a href="<?= Yii::getAlias('@web/../../frontend/web/uploads/tahapan/') . $item->dokumen ?>" target="_blank" class="btn btn-sm btn-info text-white">Lihat Dokumen</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($model->tahapanItems)): ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada item tahapan.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
