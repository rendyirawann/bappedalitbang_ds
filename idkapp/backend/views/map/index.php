<?php

use coderius\lightbox2\Lightbox2;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Map GIS Control';
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

echo Lightbox2::widget([
    'clientOptions' => [
        'resizeDuration' => 200,
        'wrapAround' => true,
    ],
]);
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
                            <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index']) ?>">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Dashboard GIS</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Dashboard GIS</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-lg-12">
                <!-- Basic Inputs -->
                <div class="card">
                    <div class="card-body">
                       

                        <div class="row">
          <div class="col-lg-12 text-center">
          <h1>Application GIS Control Map</h1>
              <img src="<?= Url::base(true)?>/lightapp/assets/images/bappeda.png" alt="" width="auto">
              <h3>Bappedalitbang Deli Sedang</h3>
          </div>
        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->

        <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h5>Google Maps</h5>
              <!-- <span>old Plugins link : <a href="https://hpneo.dev/gmaps/" target="_blank">https://hpneo.dev/gmaps/</a></span>               -->
            </div>
            <div class="card-body">
            <div id="maps" style="height: 560px;"></div> <!-- Changed id to "maps" -->
            </div>
          </div>
          <div class="card">
            <div class="card-body">
            <iframe
            width="600"
            height="450"
            style="border:0"
            loading="lazy"
            allowfullscreen
            referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCffYv72gX32WEm2c0wC-FaphNARKwSm1I&q=Bappedalitbang+Deli+Serdang,Lubuk+Pakam+WA=3.5482456257070925,98.86596412667134">
        </iframe>

            </div>
          </div>
        </div>
        <!-- [ sample-page ] end -->
      </div>
    </div>
</div>
