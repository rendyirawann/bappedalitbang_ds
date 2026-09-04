<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\DataIndividu $model */

$this->title = 'Tambah Data Septic Tank Individu';
$this->params['breadcrumbs'][] = ['label' => 'Data Septic Tank Individu', 'url' => ['index']];
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
                  <li class="breadcrumb-item"><a href="<?= Url::to(['/data-individu/index']) ?>">Data Septic Tank Individu</a></li>
                  <li class="breadcrumb-item" aria-current="page">Tambah Data Septic Tank Individu</li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="page-header-title">
                  <h2 class="mb-0">Tambah Data Septic Tank Individu</h2>
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
                <h5>Form Data Septic Tank Individu</h5>
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

