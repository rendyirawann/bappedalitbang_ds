<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Pegawai $model */


$this->params['breadcrumbs'][] = ['label' => 'Pegawai', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pegawai-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
                            [
                                'attribute' => 'statusAparatur',
                                'value' => function ($model) {
                                    return $model->statusAparatur === 1 ? 'ASN' : 'Non ASN';
                                },
                            ],
                            'namaLengkap',
                            'nip',
                            [
                                'attribute' => 'eselon',
                                'label' => 'Kategori Eselon',
                                'value' => function($model){
                                    return $model->pegawaiEselon->nm_eselon;
                                },
                            ],
                            [
                                'attribute' => 'kodeBidang',
                                'label' => 'Bidang Pegawai',
                                'value' => function($model) {
                                    return $model->bidang ? $model->bidang->bidang : 'No Bidang Assigned';
                                },
                            ],
                            
                            [
                                'attribute' => 'kodeTitle',
                                'label' => 'Jabatan Pegawai',
                                'value' => function($model){
                                    return $model->title->title;
                                },
                            ],
                            'no_hp',
                        ],
                    ]) ?>

</div>
