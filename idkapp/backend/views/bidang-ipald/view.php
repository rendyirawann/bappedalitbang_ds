<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\BidangIpald $model */

$this->title = 'View Data Bidang IPALD - ' . $model->namaBidang;
$this->params['breadcrumbs'][] = ['label' => 'Bidang Ipalds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
                  <li class="breadcrumb-item"><a href="<?= Url::to(['/bidang-ipald/index']) ?>">Data Bidang yang Kelola IPALD</a></li>
                  <li class="breadcrumb-item" aria-current="page">View Data Bidang IPALD</li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="page-header-title">
                  <h2 class="mb-0">View Data Bidang IPALD</h2>
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
              <div class="card-body">
              <h1>View Data Bidang IPALD - <?= Html::encode($model->id) ?></h1>

                <p>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>


                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'namaBidang:ntext',
                    ],
                ]) ?>


              </div>
            </div>

          </div>

          <!-- [ form-element ] end -->
        </div>
        <!-- [ Main Content ] end -->
      </div>
    </div>