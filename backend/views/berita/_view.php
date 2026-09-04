<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Berita $model */


$this->params['breadcrumbs'][] = ['label' => 'Beritas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="berita-view">

    <p>
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

</div>
