<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\AsetIpald $model */

$this->title = 'Update Aset Ipald: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Aset Ipalds', 'url' => ['index']];
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
                  <li class="breadcrumb-item"><a href="<?= Url::to(['/aset-ipald/index']) ?>">Data Aset IPALD</a></li>
                  <li class="breadcrumb-item" aria-current="page">Update Data Aset IPALD</li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="page-header-title">
                  <h2 class="mb-0">Update Data Aset IPALD</h2>
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
                <h5>Form Aset IPALD</h5>
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
