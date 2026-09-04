<style>
    @media print {
    thead {
        display: table-header-group;
    }

}

*{
    font-family: "Poppins", sans-serif;
}

</style>
<?php

/** @var yii\web\View $this */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\assets\AppAsset;
use yii\web\JsExpression;
use yii\helpers\HtmlPurifier;

AppAsset::register($this);
$this->title = 'Aplikasi Bidang Infrastruktur - Data Desa';

?>
<div class="container">

<div class="row mt-2 mb-3 mt-4">
    <div class="col-lg-12">
    <center><h2> <img src="<?= Url::base(true) ?>/lightapp/assets/images/bappeda.png" alt="IDKAPP" / style="width:46px;"> BIDANG INFRASTRUKTUR - DATA DESA </h2></center>
    </div>
</div>

<!-- DataTable with Hover -->
<div class="col-lg-12">
      <div class="card mb-4 mt-2">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Data Desa</h6>
        </div>
        <div class="table-responsive p-3">
    <table style="font-size:12px;" class="table align-items-center table-flush table-hover" id="dataTableHover">
        <thead class="thead-light">
        <tr>
                    <th>No</th>
                    <th>Kode Desa</th>
                    <th>Nama Desa</th>
                    <th>Kode Kecamatan</th>
                  </tr>
        </thead>
        <tbody style="font-weight: bold; color:darkblue;">
            <?php if (!empty($desas)): ?>
                <?php foreach ($desas as $index => $desa): ?>
                    <tr>
                    <td><?= $index + 1 ?></td>
                      <td><?= Html::encode($desa->kode) ?></td>
                      <td><?= Html::encode($desa->namaDesa) ?></td>
                      <td><?= $desa->kecamatan ? Html::encode($desa->kecamatan->namaKecamatan) : 'Tidak Diketahui' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>


        </div>
      </div>
    </div>
  </div>
  <br>
  <p><center><i>" Bidang Infrastruktur ".</i></center></p>
    </div>