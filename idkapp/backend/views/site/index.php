<style>
  #barChart,
  #pieChart,
  #statusPieChart,
  #lineChart,
  #stackedBarChart {
    width: 100%;
    height: 400px;
  }
</style>
<?php

use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\User;

/** @var yii\web\View $this */

$this->title = 'Aplikasi Infrastruktur dan Kewilayahan';
$this->registerJsFile('https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJs("
    // Horizontal Bar Chart
    var chartDomBar = document.getElementById('barChart');
    var barChart = echarts.init(chartDomBar);
    var barOption;

    barOption = {
        title: {
            text: 'Total Data'
        },
        tooltip: {},
        legend: {
            data: ['Count']
        },
        xAxis: {
            type: 'value'
        },
        yAxis: {
            type: 'category',
            data: ['Bank Sampah', 'Ipald', 'Individu', 'Jembatan', 'Hunian', 'Irigasi', 'KPSPAMS']
        },
        series: [{
            name: 'Count',
            type: 'bar',
            data: [
                {$totalDataBankSampah},
                {$totalDataIpald},
                {$totalDataIndividu},
                {$totalDataJembatan},
                {$totalDataHunian},
                {$totalDataIrigasi},
                {$totalDataKpspams}
            ]
        }]
    };

    barOption && barChart.setOption(barOption);

    window.addEventListener('resize', function() {
        barChart.resize();
        pieChart.resize();
        statusPieChart.resize();
        lineChart.resize();
        stackedBarChart.resize();
    });

    // Pie Chart (Data Distribution)
    var chartDomPie = document.getElementById('pieChart');
    var pieChart = echarts.init(chartDomPie);
    var pieOption;

    pieOption = {
        title: {
            text: 'Total Data',
            left: 'center'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            orient: 'vertical',
            left: 'left'
        },
        series: [
            {
                name: 'Count',
                type: 'pie',
                radius: '50%',
                data: [
                    { value: {$totalDataBankSampah}, name: 'Bank Sampah' },
                    { value: {$totalDataIpald}, name: 'Ipald' },
                    { value: {$totalDataIndividu}, name: 'Individu' },
                    { value: {$totalDataJembatan}, name: 'Jembatan' },
                    { value: {$totalDataHunian}, name: 'Hunian' },
                    { value: {$totalDataIrigasi}, name: 'Irigasi' },
                    { value: {$totalDataKpspams}, name: 'KPSPAMS' }
                ],
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };

    pieOption && pieChart.setOption(pieOption);

    // Pie Chart (Status Distribution)
    var chartDomStatusPie = document.getElementById('statusPieChart');
    var statusPieChart = echarts.init(chartDomStatusPie);
    var statusPieOption;

    var statusCounts = " . json_encode($statusCounts) . ";
    var statusPieData = statusCounts.map(function(item) {
        return { value: item.count, name: item.status };
    });

    statusPieOption = {
        title: {
            text: 'Status Bank Sampah',
            left: 'center'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            orient: 'vertical',
            left: 'left'
        },
        series: [
            {
                name: 'Status',
                type: 'pie',
                radius: '50%',
                data: statusPieData,
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };

    statusPieOption && statusPieChart.setOption(statusPieOption);

    // Line Chart
    var chartDomLine = document.getElementById('lineChart');
    var lineChart = echarts.init(chartDomLine);
    var lineOption;

    var tahunPembangunanCounts = " . json_encode($tahunPembangunanCounts) . ";
    var lineData = tahunPembangunanCounts.map(function(item) {
        return { value: item.count, name: item.tahunPembangunan };
    });

    lineOption = {
        title: {
            text: 'Pembangunan Trend'
        },
        tooltip: {
            trigger: 'axis'
        },
        xAxis: {
            type: 'category',
            data: lineData.map(function(item) { return item.name; })
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            name: 'Count',
            type: 'line',
            data: lineData.map(function(item) { return item.value; })
        }]
    };

    lineOption && lineChart.setOption(lineOption);

    // Stacked Bar Chart
    var chartDomStackedBar = document.getElementById('stackedBarChart');
    var stackedBarChart = echarts.init(chartDomStackedBar);
    var stackedBarOption;

    var nilaiData = " . json_encode($nilaiData) . ";
    var pekerjaan = nilaiData.map(function(item) { return item.namaPekerjaan; });
    var nilaiPagu = nilaiData.map(function(item) { return item.nilaiPagu; });
    var nilaiKontrak = nilaiData.map(function(item) { return item.nilaiKontrak; });
    var nilaiAddendum = nilaiData.map(function(item) { return item.nilaiAddendum; });

    stackedBarOption = {
        title: {
            text: 'Nilai Comparison'
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: { type: 'shadow' }
        },
        legend: {},
        xAxis: {
            type: 'category',
            data: pekerjaan
        },
        yAxis: {
            type: 'value'
        },
        series: [
            { name: 'Nilai Pagu', type: 'bar', stack: 'total', data: nilaiPagu },
            { name: 'Nilai Kontrak', type: 'bar', stack: 'total', data: nilaiKontrak },
            { name: 'Nilai Addendum', type: 'bar', stack: 'total', data: nilaiAddendum }
        ]
    };

    stackedBarOption && stackedBarChart.setOption(stackedBarOption);
");
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
              <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index']) ?>">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page">Home</li>
            </ul>
          </div>
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0">Home</h2>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <!-- <div class="row">
      <div class="col-lg-12 text-center">
        <h1>Dashboard Aplikasi Infrastruktur dan Kewilayahan</h1>
        <img src="<?= Url::base(true) ?>/lightapp/assets/images/bappeda.png" alt="" width="auto">
        <h3>Bappedalitbang Deli Sedang</h3>
      </div>
    </div> -->
    <!--  -->
    <div class="row">
      <!-- start row -->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header" style="background-color: #04A9F5; padding: 8px;">
            <h6 style="color: white; margin: 0; cursor: pointer;" id="toggleAll">
              <i class="fas fa-pen-fancy"></i>Periode Data Capaian Tahunan Indikator Sasaran Renstra - <?= Html::encode(ucwords(strtolower($nama_skpd))) ?>
            </h6>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <!-- Dropdown filter berdasarkan refperiode_id -->
                <?= \yii\helpers\Html::beginForm(['index'], 'get', ['class' => 'form-inline']); ?>
                <div class="form-group">
                  <?= \yii\helpers\Html::label('Pilih Periode:', 'refperiode_id', ['class' => 'mr-2']); ?>
                  <?= \yii\helpers\Html::dropDownList(
                    'refperiode_id',
                    $selectedPeriodId,
                    \yii\helpers\ArrayHelper::map($periodeList, 'refperiode_id', 'periode'), // Mapping periodeList
                    [
                      'class' => 'form-control',
                      'prompt' => 'Pilih Periode',
                      'onchange' => 'this.form.submit()' // Submit form saat pilihan berubah
                    ]
                  ); ?>
                </div>
                <div class="form-group ml-3">
                  <?= \yii\helpers\Html::label('Pilih SKPD:', 'refskpd_id', ['class' => 'mr-2']); ?>
                  <?= \yii\helpers\Html::dropDownList(
                    'refskpd_id',
                    $selectedSkpdId,
                    $skpdList,
                    [
                      'class' => 'form-control',
                      'prompt' => 'Pilih SKPD',
                      'onchange' => 'this.form.submit()'
                    ]
                  ); ?>
                </div>
                <?= \yii\helpers\Html::endForm(); ?>
              </div>
            </div>
          </div>
        </div>
        <!-- End Card -->

        <!-- Table Start -->
        <div class="card">
          <div class="card-header" style="background-color: #04A9F5; padding: 8px;">
            <h6 style="color: white; margin: 0; cursor: pointer;" id="toggleAll">
              <i class="fas fa-pen-fancy"></i>Data Capaian Tahunan Indikator Sasaran Renstra - <?= Html::encode(ucwords(strtolower($nama_skpd))) ?> (Periode <?= $selectedPeriodValue ?>)
            </h6>
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

            <?php if ($dataEmpty): ?>
              <div class="alert alert-warning mt-4">
                Data tidak ada untuk periode yang dipilih.
              </div>
            <?php else: ?>
              <div class="dt-responsive table-responsive">
                <?php
                $lastSasaranRenstraId = null;
                $no = 1;
                foreach ($data as $indikator):
                  // Jika refsasaranrenstra_id berubah, tampilkan uraian_sasaranrenstra
                  if ($lastSasaranRenstraId !== $indikator->refsasaranrenstra_id):
                ?>
                    <table class="table table-striped table-hover table-bordered nowrap" style="font-size:xx-small;">
                      <thead>
                        <tr>
                          <th colspan="9" style="background-color: #04A9F5; color: white; white-space:normal;">
                            Sasaran <?= $no ?>: <?= $indikator->refSasaranrenstra->uraian_sasaranrenstra ?>
                          </th>
                        </tr>
                        <tr>
                          <th style="background-color: #e23c3c; color: white; white-space:normal;">No</th>
                          <th style="background-color: #e23c3c; color: white; white-space:normal;">Indikator</th>
                          <th style="background-color: #e23c3c; color: white; white-space:normal;">Satuan</th>
                          <th style="background-color: #e23c3c; color: white; white-space:normal;">IKU</th>
                          <th style="background-color: #e23c3c; color: white; white-space:normal;">PK</th>
                          <th style="background-color: #e23c3c; color: white; white-space:normal;">Target Tahunan</th>
                          <th style="background-color: #e23c3c; color: white; white-space:normal;">Realisasi</th>
                          <th style="background-color: #e23c3c; color: white; white-space:normal;">Capaian</th>

                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      // Reset counter for indikator number within the same sasaranrenstra
                      $no = 1;
                      $lastSasaranRenstraId = $indikator->refsasaranrenstra_id;
                    endif;
                      ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td style="white-space:normal;"><?= $indikator->uraian_indikatorsasaranrenstra ?></td>
                        <td><?= $indikator->indikatorsasaranrenstra_satuan ?></td>
                        <td class="text-center align-middle">
                          <?php if ($indikator->iku_isaktif === 'T'): ?>
                            <span class="badge bg-success">AKTIF</span>
                          <?php else: ?>
                            <span class="badge bg-danger">Non Aktif</span>
                          <?php endif; ?>
                        </td>
                        <td class="text-center align-middle">
                          <?php if ($indikator->pk_isaktif === 'T'): ?>
                            <span class="badge bg-success">AKTIF</span>
                          <?php else: ?>
                            <span class="badge bg-danger">Non Aktif</span>
                          <?php endif; ?>
                        </td>
                        <td><?= $indikator->target_rkt ?></td>
                        <td><?= $indikator->realisasi ?></td>
                        <td><?= $indikator->capaian ?></td>

                      </tr>
                      <?php
                      // Tutup table jika ini indikator terakhir dari suatu refsasaranrenstra_id
                      $next = next($data);
                      if (!$next || $next->refsasaranrenstra_id !== $lastSasaranRenstraId): ?>
                      </tbody>
                    </table>
                <?php
                      endif;
                    endforeach; ?>
              </div>
            <?php endif; ?>
            <!--  -->
            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border-radius: 20px;">
                  <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <!-- The form will be loaded here -->
                    <div id="modalFormContent" style="padding-bottom:20px; padding-right:15px; padding-left:15px;">
                      <!-- AJAX-loaded content will be injected here -->
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <!--  -->
            <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border-radius: 20px;">
                  <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Data Capaian Tahunan Indikator Sasaran Renstra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <!-- The form will be loaded here -->
                    <div id="modalUpdateFormContent" style="padding-bottom:20px; padding-right:15px; padding-left:15px;">
                      <!-- AJAX-loaded content will be injected here -->
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <!--  -->

          </div>
        </div>

        <!-- Table end -->
      </div>
      <!-- end row -->
    </div>

    <!--  -->
    <div class="row">
      <h3>Data Infrastruktur</h3>
      <?php
      $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
      $user = User::findOne(Yii::$app->user->getId());
      $allowedSkpd = ['1.04.1.03.2.11.02.0000', '2.11.0.00.0.00.01.0000'];

      if (isset($assignments['opd']) && in_array($user->instansi->kode_skpd, $allowedSkpd) || isset($assignments['superadmin']) || isset($assignments['admin'])) {
      ?>
        <div class="col-md-6 col-xl-4">
          <div class="card statistics-card-1 overflow-hidden ">
            <div class="card-body">
              <img src="<?= Url::base(true) ?>/lightapp/assets/images/widget/img-status-7.svg" alt="img" class="img-fluid img-bg">
              <div class="media align-items-center">
                <i class="fas fa-water"></i>
                <div class="media-body ms-3">
                  <p class="mb-0 text-muted">Total - Bank Sampah</p>
                  <div class="d-inline-flex align-items-center">
                    <h5 class="f-w-300 d-flex align-items-center m-b-0"><?= $totalDataBankSampah ?></h5>
                    <span class="badge bg-success ms-2">-%</span>
                  </div>
                </div>
              </div>
              <div class="row g-3 mt-5 text-center">
                <div class="col-6">
                  <p class="mb-0 text-muted">Tahun Ini</p>
                  <h5 class="mb-0"><?= $currentYearCount ?></h5>
                </div>
                <div class="col-6 border-start">
                  <p class="mb-0 text-muted">Tahun Lalu</p>
                  <h5 class="mb-0"><?= $lastYearCount ?></h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php
      $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
      $user = User::findOne(Yii::$app->user->getId());
      $allowedSkpd = ['1.04.1.03.2.11.02.0000'];

      if (isset($assignments['opd']) && in_array($user->instansi->kode_skpd, $allowedSkpd) || isset($assignments['superadmin']) || isset($assignments['admin'])) {
      ?>

        <div class="col-md-6 col-xl-4">
          <div class="card statistics-card-1 overflow-hidden ">
            <div class="card-body">
              <img src="<?= Url::base(true) ?>/lightapp/assets/images/widget/img-status-8.svg" alt="img" class="img-fluid img-bg">
              <div class="media align-items-center">
                <i class="fas fa-road"></i>
                <div class="media-body ms-3">
                  <p class="mb-0 text-muted">Total - IPAL/IPALD</p>
                  <div class="d-inline-flex align-items-center">
                    <h5 class="f-w-300 d-flex align-items-center m-b-0"><?= $totalDataIpald ?></h5>
                    <span class="badge bg-success ms-2">+-%</span>
                  </div>
                </div>
              </div>
              <div class="row g-3 mt-5 text-center">
                <div class="col-6">
                  <p class="mb-0 text-muted">Tahun Ini</p>
                  <h5 class="mb-0"><?= $currentYearCountIpald ?></h5>
                </div>
                <div class="col-6 border-start">
                  <p class="mb-0 text-muted">Tahun Lalu</p>
                  <h5 class="mb-0"><?= $lastYearCountIpald ?></h5>
                </div>
              </div>
            </div>
          </div>
        </div>




        <div class="col-md-6 col-xl-4">
          <div class="card statistics-card-1 overflow-hidden ">
            <div class="card-body">
              <img src="<?= Url::base(true) ?>/lightapp/assets/images/widget/img-status-8.svg" alt="img" class="img-fluid img-bg">
              <div class="media align-items-center">
                <i class="fas fa-road"></i>
                <div class="media-body ms-3">
                  <p class="mb-0 text-muted">Total - Septic Tank</p>
                  <div class="d-inline-flex align-items-center">
                    <h5 class="f-w-300 d-flex align-items-center m-b-0"><?= $totalDataIndividu ?></h5>
                    <span class="badge bg-success ms-2">+-%</span>
                  </div>
                </div>
              </div>
              <div class="row g-3 mt-5 text-center">
                <div class="col-6">
                  <p class="mb-0 text-muted">Tahun Ini</p>
                  <h5 class="mb-0"><?= $currentYearCountIndividu ?></h5>
                </div>
                <div class="col-6 border-start">
                  <p class="mb-0 text-muted">Tahun Lalu</p>
                  <h5 class="mb-0"><?= $lastYearCountIndividu ?></h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php
      $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
      $user = User::findOne(Yii::$app->user->getId());
      $allowedSkpd = ['1.03.0.00.0.00.01.0000'];

      if (isset($assignments['opd']) && in_array($user->instansi->kode_skpd, $allowedSkpd) || isset($assignments['superadmin']) || isset($assignments['admin'])) {
      ?>

        <div class="col-md-6 col-xl-4">
          <div class="card statistics-card-1 overflow-hidden ">
            <div class="card-body">
              <img src="<?= Url::base(true) ?>/lightapp/assets/images/widget/img-status-8.svg" alt="img" class="img-fluid img-bg">
              <div class="media align-items-center">
                <i class="fas fa-road"></i>
                <div class="media-body ms-3">
                  <p class="mb-0 text-muted">Total - Kegiatan Jembatan</p>
                  <div class="d-inline-flex align-items-center">
                    <h5 class="f-w-300 d-flex align-items-center m-b-0"><?= $totalDataJembatan ?></h5>
                    <span class="badge bg-success ms-2">+-%</span>
                  </div>
                </div>
              </div>
              <div class="row g-3 mt-5 text-center">
                <div class="col-6">
                  <p class="mb-0 text-muted">Tahun Ini</p>
                  <h5 class="mb-0"><?= $currentYearCountJembatan ?></h5>
                </div>
                <div class="col-6 border-start">
                  <p class="mb-0 text-muted">Tahun Lalu</p>
                  <h5 class="mb-0"><?= $lastYearCountJembatan ?></h5>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-xl-4">
          <div class="card statistics-card-1 overflow-hidden">
            <div class="card-body">
              <img src="<?= Url::base(true) ?>/lightapp/assets/images/widget/img-status-9.svg" alt="img" class="img-fluid img-bg">
              <div class="media align-items-center">
                <i class="fas fa-tint"></i>
                <div class="media-body ms-3">
                  <p class="mb-0 text-muted">Total - Irigasi</p>
                  <div class="d-inline-flex align-items-center">
                    <h5 class="f-w-300 d-flex align-items-center m-b-0"><?= $totalDataIrigasi ?></h5>
                    <span class="badge bg-success ms-2">+-%</span>
                  </div>
                </div>
              </div>
              <div class="row g-3 mt-5 text-center">
                <div class="col-6">
                  <p class="mb-0 text-muted">Tahun ini</p>
                  <h5 class="mb-0"><?= $currentYearCountIrigasi ?></h5>
                </div>
                <div class="col-6 border-start">
                  <p class="mb-0 text-muted">Tahun Lalu</p>
                  <h5 class="mb-0"><?= $lastYearCountIrigasi ?></h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php
      $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
      $user = User::findOne(Yii::$app->user->getId());
      $allowedSkpd = ['1.04.2.10.0.00.01.0000'];

      if (isset($assignments['opd']) && in_array($user->instansi->kode_skpd, $allowedSkpd) || isset($assignments['superadmin']) || isset($assignments['admin'])) {
      ?>

        <div class="col-md-6 col-xl-4">
          <div class="card statistics-card-1 overflow-hidden">
            <div class="card-body">
              <img src="<?= Url::base(true) ?>/lightapp/assets/images/widget/img-status-8.svg" alt="img" class="img-fluid img-bg">
              <div class="media align-items-center">
                <i class="fas fa-building"></i>
                <div class="media-body ms-3">
                  <p class="mb-0 text-muted">Total - Hunian</p>
                  <div class="d-inline-flex align-items-center">
                    <h5 class="f-w-300 d-flex align-items-center m-b-0"><?= $totalDataHunian ?></h5>
                    <span class="badge bg-success ms-2">+-%</span>
                  </div>
                </div>
              </div>
              <div class="row g-3 mt-5 text-center">
                <div class="col-6">
                  <p class="mb-0 text-muted">Tahun Ini</p>
                  <h5 class="mb-0"><?= $currentYearCountHunian ?></h5>
                </div>
                <div class="col-6 border-start">
                  <p class="mb-0 text-muted">Tahun Lalu</p>
                  <h5 class="mb-0"><?= $lastYearCountHunian ?></h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php
      $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
      $user = User::findOne(Yii::$app->user->getId());
      $allowedSkpd = ['1.04.1.03.2.11.02.0000'];

      if (isset($assignments['opd']) && in_array($user->instansi->kode_skpd, $allowedSkpd) || isset($assignments['superadmin']) || isset($assignments['admin'])) {
      ?>

        <div class="col-md-6 col-xl-12">
          <div class="card statistics-card-1 overflow-hidden">
            <div class="card-body">
              <img src="<?= Url::base(true) ?>/lightapp/assets/images/widget/img-status-9.svg" alt="img" class="img-fluid img-bg">
              <div class="media align-items-center">
                <i class="fas fa-tint"></i>
                <div class="media-body ms-3">
                  <p class="mb-0 text-muted">Total - KPSPAMS</p>
                  <div class="d-inline-flex align-items-center">
                    <h5 class="f-w-300 d-flex align-items-center m-b-0"><?= $totalDataKpspams ?></h5>
                    <span class="badge bg-success ms-2">+-%</span>
                  </div>
                </div>
              </div>
              <div class="row g-3 mt-5 text-center">
                <div class="col-6">
                  <p class="mb-0 text-muted">Tahun ini</p>
                  <h5 class="mb-0"><?= $currentYearCountKpspams ?></h5>
                </div>
                <div class="col-6 border-start">
                  <p class="mb-0 text-muted">Tahun Lalu</p>
                  <h5 class="mb-0"><?= $lastYearCountKpspams ?></h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>


    </div>
    <!--  -->

    <!-- [ Main Content ] start -->
    <?php
    $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
    $user = User::findOne(Yii::$app->user->getId());

    if (isset($assignments['superadmin']) || isset($assignments['admin'])) {
    ?>
      <div class="row">
        <!-- [ Horizontal Bar Chart ] start -->
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h5>Data Infrastruktur - Horizontal Bar Chart</h5>
            </div>
            <div class="card-body">
              <div id="barChart"></div>
            </div>
          </div>
        </div>
        <!-- [ Horizontal Bar Chart ] end -->

        <!-- [ Pie Chart ] start -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h5>Data Infrastruktur - Pie Chart</h5>
            </div>
            <div class="card-body">
              <div id="pieChart"></div>
            </div>
          </div>
        </div>
        <!-- [ Pie Chart ] end -->

        <!-- [ Status Pie Chart ] start -->
        <!-- <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h5>Data Infrastruktur - Status Pie Chart</h5>
          </div>
          <div class="card-body">
            <div id="statusPieChart"></div>
          </div>
        </div>
      </div> -->
        <!-- [ Status Pie Chart ] end -->

        <!-- [ Line Chart ] start -->
        <!-- <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h5>Data Infrastruktur - Line Chart</h5>
          </div>
          <div class="card-body">
            <div id="lineChart"></div>
          </div>
        </div>
      </div> -->
        <!-- [ Line Chart ] end -->

        <!-- [ Stacked Bar Chart ] start -->
        <!-- <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h5>Data Infrastruktur - Stacked Bar Chart</h5>
          </div>
          <div class="card-body">
            <div id="stackedBarChart"></div>
          </div>
        </div>
      </div> -->
        <!-- [ Stacked Bar Chart ] end -->
      </div>
    <?php } ?>
    <!-- [ Main Content ] end -->


  </div>
  <!-- [ Main Content ] end -->
</div>
</div>
<!-- [ Main Content ] end -->