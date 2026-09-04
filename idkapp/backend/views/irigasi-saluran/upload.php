<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\TblIpald $model */

$this->title = 'Upload CSV to Database';
$this->params['breadcrumbs'][] = ['label' => 'Data Individu 2023', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
              <li class="breadcrumb-item"><a href="../dashboard/index.html">Homee</a></li>
              <li class="breadcrumb-item"><a href="javascript: void(0)">Forms</a></li>
              <li class="breadcrumb-item" aria-current="page">Form Option</li>
            </ul>
          </div>
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0">Form Option</h2>
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
            <h5>Upload Data CSV</h5>
          </div>
          <div class="card-body">
            <?php if (Yii::$app->session->hasFlash('success')) : ?>
              <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success') ?>
              </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('error')) : ?>
              <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
              </div>
            <?php endif; ?>
            <?= $this->render('_upload', [
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