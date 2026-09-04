<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\StandarPelayanan $model */

\yii\web\YiiAsset::register($this);
?>
<div class="standar-pelayanan-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
                <?= Html::a('<i class="fa fa-download"></i>', ['download', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'file',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->isPdf) {
                        return '<iframe src="' . Url::to('@web/uploads/standar-pelayanan/' . $model->file) . '" width="100%" height="500px" style="border:none;"></iframe>';
                    }
                    return Html::img('@web/uploads/standar-pelayanan/' . $model->file, ['style' => 'max-width:100%;']);
                },
            ],
            'namaFile',
            'tahun',
        ],
    ]) ?>

</div>
