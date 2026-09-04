<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\Visimisi $model */

$this->title = 'Tambah Visi dan Misi';
$this->params['breadcrumbs'][] = ['label' => 'Visimisis', 'url' => ['index']];
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
          <a href="<?= Url::to(['/visimisi/index']) ?>">Visi dan Misi</a>
        </li>
        <li class="breadcrumb-item active">Tambah Visi dan Misi</li>
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
