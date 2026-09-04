<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\BeritaAlt $model */

$this->title = 'Tambah Gambar Berita Perencanaan';
$this->params['breadcrumbs'][] = ['label' => 'Berita Alts', 'url' => ['index']];
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
        <a href="<?= Url::to(['/berita/view', 'id' => $model->berita_id]) ?>">Berita Perencanaan</a>
      </li>
      <li class="breadcrumb-item active">Tambah Gambar Berita Perencanaan</li>
    </ol>
    <!-- Example DataTables Card-->
    <div class="card mb-3">
      <div class="card-header">
        <h1><?= Html::encode($this->title) ?></h1>
      </div>
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