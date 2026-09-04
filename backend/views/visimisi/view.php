<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Visimisi $model */

$this->title = 'Bappedalitbang DS';
$this->params['breadcrumbs'][] = ['label' => 'Visimisis', 'url' => ['index']];
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
          <a href="<?= Url::to(['/visimisi/index']) ?>">Visi dan Misi</a>
        </li>
        <li class="breadcrumb-item active">View Visi dan Misi</li>
      </ol>
		<!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header"><h1>Detail Visi dan Misi - <?= Html::encode($this->title) ?></h1></div>
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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'visiJudul',
                'format' => 'raw',
            ],
            [
                'attribute' => 'visiTeks',
                'format' => 'raw',
            ],
            [
                'attribute' => 'misiJudul',
                'format' => 'raw',
            ],
            [
                'attribute' => 'misiTeks',
                'format' => 'raw',
            ],
        ],
    ]) ?>
        </div>

      </div>
	  <!-- /tables-->
	  </div>
	  <!-- /container-fluid-->
   	</div>
    <!-- /container-wrapper-->
