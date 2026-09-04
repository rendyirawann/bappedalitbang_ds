<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\DataIpald $model */

$this->title = 'Update Data Ipald: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Ipalds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<!-- [ Main Content ] start -->
<div class="pc-container">
  <div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index']) ?>">Homee</a></li>
              <li class="breadcrumb-item"><a href="<?= Url::to(['/data-ipald/index']) ?>">Data IPALD</a></li>
              <li class="breadcrumb-item" aria-current="page">Update Data IPALD</li>
            </ul>
          </div>
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0">Update Data IPALD</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- [ breadcrumb ] end -->


    <!-- [ Main Content ] start -->
    <div class="row">
      <!-- [ form-element ] start -->
      <div class="col-lg-12">
        <!-- Basic Inputs -->
        <div class="card">
          <div class="card-header">
            <h5>Form Data IPALD</h5>
          </div>
          <div class="card-body">
            <?= $this->render('_formupdate', [
              'model' => $model,
            ]) ?>
          </div>
        </div>
      </div>
      <!-- [ form-element ] end -->
    </div>
    <!-- [ Main Content ] end -->
  </div>
</div>