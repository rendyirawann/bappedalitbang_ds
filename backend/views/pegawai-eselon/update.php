<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\PegawaiEselon $model */

$this->title = 'Update Pegawai Eselon: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pegawai Eselons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= Url::to(['/site/index']) ?>">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?= Url::to(['/pegawai-eselon/index']) ?>">Kategori Eselon</a>
        </li>
        <li class="breadcrumb-item active">Update Kategori Eselon</li>
      </ol>
		<!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
        <h1><?= Html::encode($this->title) ?></h1></div>
        <div class="card-body">
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
