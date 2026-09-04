<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\TblSampah $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Sampahs', 'url' => ['index']];
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
                <h5>Basic Inputs</h5>
              </div>
              <div class="card-body">
              <h1><?= Html::encode($this->title) ?></h1>

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
            'no',
            'enumerator:ntext',
            'fasilitas:ntext',
            'lokasi:ntext',
            'kondisi:ntext',
            'thn_pembangunan',
            'thn_optimalisasi',
            'kegiatan_pengurangan:ntext',
            'jlh_sampah_masuk',
            'jlh_sampah_terolah',
            'jlh_sampah_residu',
            'pengelola:ntext',
            'nama_lembaga:ntext',
            'bentuk_lembaga:ntext',
            'jlh_anggota:ntext',
            'kel_bidang:ntext',
            'wilayah:ntext',
            'operasional:ntext',
            'asset:ntext',
            'status:ntext',
            'latitude',
            'longitude',
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