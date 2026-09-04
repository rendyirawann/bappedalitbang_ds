<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\IrigasiSaluran $model */

$this->title = 'Tambah Irigasi Saluran';
$this->params['breadcrumbs'][] = ['label' => 'Irigasi Saluran', 'url' => ['index']];
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
                            <li class="breadcrumb-item"><a href="<?= Url::to(['/irigasi-saluran/index']) ?>">Data Irigasi Saluran</a></li>
                            <li class="breadcrumb-item" aria-current="page">Tambah Data Irigasi Saluran</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Tambah Data Irigasi Saluran</h2>
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
                        <h5>Form Data Irigasi Saluran</h5>
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