<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\User $model */

$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="galeri-view">

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
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    if ($model->status == 10) {
                        return '<i class="fa fa-check-circle" style="color:green;">Akun Aktif</i>';
                    }else {
                        return 'Akun Belum Diverifikasi dan Belum Aktif';
                    }
                },
                'format' => 'raw', // Pastikan untuk mengatur format ke 'raw'
            ],
            [
                'attribute' => 'bidang_id',
                'label' => 'Nama Bidang', // Ganti label di sini
                'value' => function ($model) {
                    return $model->bidang ? $model->bidang->bidang : 'Bidang Belum di Set';
                },
            ],            
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
