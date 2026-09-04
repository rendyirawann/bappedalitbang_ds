<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\StandarPelayanan $model */

$this->title = 'Tambah Standar Pelayanan';
$this->params['breadcrumbs'][] = ['label' => 'Standar Pelayanan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= Url::to(['/site/index']) ?>">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?= Url::to(['/standar-pelayanan/index']) ?>">Standar Pelayanan</a>
        </li>
        <li class="breadcrumb-item active">Tambah Standar Pelayanan</li>
      </ol>
			<!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
        <h1><?= Html::encode($this->title) ?></h1></div>
        <div class="card-body">
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
        <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
        </div>

      </div>
	  <!-- /tables-->
	  </div>
	  <!-- /container-fluid-->
   	</div>
    <!-- /container-wrapper-->
