<?php

use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\HeroSlider $model */

$this->title = 'Tambah Banner';
$this->params['breadcrumbs'][] = ['label' => 'Banner Halaman Depan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-wrapper">
  <div class="container-fluid">

    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index']) ?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?= Url::to(['index']) ?>">Banner Halaman Depan</a></li>
      <li class="breadcrumb-item active">Tambah Banner</li>
    </ol>

    <div class="card mb-3">
      <div class="card-header"><i class="fa fa-plus"></i> Tambah Banner</div>
      <div class="card-body">
        <?= $this->render('_form', ['model' => $model]) ?>
      </div>
    </div>

  </div>
</div>
