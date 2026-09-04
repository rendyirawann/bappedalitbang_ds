<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\SampahDokumen $model */

$this->title = 'Create Sampah Dokumen';
$this->params['breadcrumbs'][] = ['label' => 'Sampah Dokumens', 'url' => ['index']];
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
                  <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index']) ?>">Homee</a></li>
                  <li class="breadcrumb-item"><a href="<?= Url::to(['/data-sampah/index']) ?>">Data Sampah</a></li>
                  <li class="breadcrumb-item" aria-current="page">Tambah Dokumen Sampah</li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="page-header-title">
                  <h2 class="mb-0">Tambah Data Sampah</h2>
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
                <h5>Form Data Sampah</h5>
              </div>
              <div class="card-body">
              <?= $this->render('_form', [
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
