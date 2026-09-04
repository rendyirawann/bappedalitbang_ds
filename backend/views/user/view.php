<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\User $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
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
          <a href="<?= Url::to(['/user/index']) ?>">User</a>
        </li>
        <li class="breadcrumb-item active">View User</li>
      </ol>
		<!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header"><h1>Detail User - <?= Html::encode($this->title) ?></h1></div>
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

      </div>
	  <!-- /tables-->
	  </div>
	  <!-- /container-fluid-->
   	</div>
    <!-- /container-wrapper-->
