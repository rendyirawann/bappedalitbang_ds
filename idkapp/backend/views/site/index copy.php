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
            data: ['Bank Sampah', 'Ipald', 'Individu', 'Jembatan', 'Hunian']
        },
        series: [{
            name: 'Count',
            type: 'bar',
            data: [
                {$totalDataBankSampah},
                {$totalDataIpald},
                {$totalDataIndividu},
                {$totalDataJembatan},
                {$totalDataHunian}
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
                    { value: {$totalDataHunian}, name: 'Hunian' }
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
      <h3>Target Realisasi Capaian Tahunan OPD 2024</h3>
      <?php foreach ($targetIndikatorData as $data) : ?>
        <div class="col-lg-12 col-xl-12">
          <div class="card statistics-card-1 overflow-hidden">
            <div class="card-body">
              <h4><i class="fas fa-bullseye"></i> <?= Html::encode($data['user']->instansi->instansi) ?></h4>
              <img src="<?= Url::base(true) ?>/lightapp/assets/images/widget/img-status-7.svg" alt="img" class="img-fluid img-bg">
              <div class="row g-3 mt-5">
                <div class="col-md-12">
                  <p class="mb-0 text-muted" style="text-align: left;">Sasaran & Indikator</p>
                  <div class="dt-responsive table-responsive mt-2">
                    <table id="table-style-hover" class="table table-striped table-hover table-bordered nowrap" style="font-size:medium;">
                      <thead>
                        <tr>
                          <th rowspan="2">Sasaran - Indikator Renstra</th>
                          <?php for ($tahun_id = 1; $tahun_id <= 5; $tahun_id++) : ?>
                            <th rowspan="2">Target <?= 2019 + $tahun_id ?></th>
                            <th rowspan="2">Realisasi <?= 2019 + $tahun_id ?></th>
                            <th rowspan="2">Capaian <?= 2019 + $tahun_id ?></th>
                          <?php endfor; ?>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data['indicators'][1] as $index => $targetIndikator) : ?>
                          <tr>
                            <td><?= Html::encode(($index + 1) . '. ' . $targetIndikator['refsasaranrenstra']->refsasaranrenstra_uraian) ?>
                              - <?= Html::encode($targetIndikator['refsasaran_indikator']) ?>
                            </td>

                            <?php for ($tahun_id = 1; $tahun_id <= 5; $tahun_id++) : ?>
                              <td><?= Html::encode($data['indicators'][$tahun_id][$index]['targetIndikator']->target_pk_p ?? 'Target Belum di Tentukan di ESAKIP') ?></td>
                              <td><?= Html::encode($data['indicators'][$tahun_id][$index]['targetIndikator']->realisasi ?? 'Realisasi Belum di Tentukan di ESAKIP') ?></td>
                              <td><?= Html::encode($data['indicators'][$tahun_id][$index]['targetIndikator']->capaian ?? 'Capaian Belum di Tentukan di ESAKIP') ?>%</td>
                            <?php endfor; ?>
                            <!-- <td>(buat sebuah tombol update dengan mengambil data primary nya yaitu indikator_id dari target_indikator_sasaran) yang akan membuka page target-indikator-sasaran/update</td> -->

                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>


    </div>
    <!--  -->
    <div class="row">
      <h3>Data Infrastruktur</h3>
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
                <h5 class="mb-0">-</h5>
              </div>
              <div class="col-6 border-start">
                <p class="mb-0 text-muted">Tahun Lalu</p>
                <h5 class="mb-0">-</h5>
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
                <h5 class="mb-0">-</h5>
              </div>
              <div class="col-6 border-start">
                <p class="mb-0 text-muted">Tahun Lalu</p>
                <h5 class="mb-0">-</h5>
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
                <h5 class="mb-0">-</h5>
              </div>
              <div class="col-6 border-start">
                <p class="mb-0 text-muted">Tahun Lalu</p>
                <h5 class="mb-0">-</h5>
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
                <h5 class="mb-0">-</h5>
              </div>
              <div class="col-6 border-start">
                <p class="mb-0 text-muted">Tahun Lalu</p>
                <h5 class="mb-0">-</h5>
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
                <h5 class="mb-0">-</h5>
              </div>
              <div class="col-6 border-start">
                <p class="mb-0 text-muted">Tahun Lalu</p>
                <h5 class="mb-0">-</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-4">
        <div class="card statistics-card-1 overflow-hidden ">
          <div class="card-body">
            <img src="<?= Url::base(true) ?>/lightapp/assets/images/widget/img-status-9.svg" alt="img" class="img-fluid img-bg">
            <div class="media align-items-center">
              <i class="fas fa-tint"></i>
              <div class="media-body ms-3">
                <p class="mb-0 text-muted">Total - Irigasi</p>
                <div class="d-inline-flex align-items-center">
                  <h5 class="f-w-300 d-flex align-items-center m-b-0">-</h5>
                  <span class="badge bg-success ms-2">+-%</span>
                </div>
              </div>
            </div>
            <div class="row g-3 mt-5 text-center">
              <div class="col-6">
                <p class="mb-0 text-muted">Target</p>
                <h5 class="mb-0">-</h5>
              </div>
              <div class="col-6 border-start">
                <p class="mb-0 text-muted">Duration</p>
                <h5 class="mb-0">-</h5>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
    <!--  -->

    <!-- [ Main Content ] start -->
    <div class="row">
      <!-- [ Horizontal Bar Chart ] start -->
      <div class="col-lg-6">
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
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h5>Data Infrastruktur - Status Pie Chart</h5>
          </div>
          <div class="card-body">
            <div id="statusPieChart"></div>
          </div>
        </div>
      </div>
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
    <!-- [ Main Content ] end -->


  </div>
  <!-- [ Main Content ] end -->
</div>
</div>
<!-- [ Main Content ] end -->