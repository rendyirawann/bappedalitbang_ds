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
    var chartDomBar = document.getElementById('barChart');
    var barChart = echarts.init(chartDomBar);
    var barOption;

   function updateChart(data) {
    var filterDescription = 'Total Data';
    filterDescription += ' ' + data.type;
    if (data.desa) {
        filterDescription += '\\nDesa: ' + data.desa;
    }
    if (data.kecamatan) {
        filterDescription += ' - Kecamatan: ' + data.kecamatan;
    }
    if (data.year) {
        filterDescription += ' - Year: ' + data.year;
    }

    // Kondisi untuk menentukan data yang digunakan untuk xAxis dan series
    var xAxisData = data.desaData ? data.desaData.map(item => item.kodeDesa) : data.kecamatanData.map(item => item.kodeKecamatan);
    var seriesData = data.desaData ? data.desaData.map(item => item.total) : data.kecamatanData.map(item => item.total);

    barOption = {
        title: {
            text: filterDescription,
            textStyle: {
                fontSize: 14
            }
        },
        tooltip: {},
        legend: {
            data: ['Count'],
            orient: 'vertical',
            align: 'right',
            right: 10,
            top: 'top',
            textStyle: {
                fontSize: 12
            }
        },
        xAxis: {
            type: 'category',
            data: xAxisData
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            name: 'Count',
            type: 'bar',
            data: seriesData
        }]
    };

    barChart.setOption(barOption);
}

function loadDefaultChart() {
    updateChart({
        type: 'Ipald',
        total: {$totalDataIpald},
        kecamatanData: {$kecamatanDataIpald}
    });
}

// Initial chart load
loadDefaultChart();

window.addEventListener('resize', function() {
    barChart.resize();
});


        function applyFilter() {
    var selectedType = $('#dataTypeFilter').val();
    var selectedDesa = $('#desaFilter').val();
    var selectedKecamatan = $('#kecamatanFilter').val();
    var selectedYear = $('#yearFilter').val();

    if (!selectedKecamatan) {
        if (selectedDesa || selectedYear) {
            $.ajax({
                url: '" . \yii\helpers\Url::to(['filter-data']) . "',
                method: 'GET',
                data: { dataType: selectedType, kodeDesa: selectedDesa, year: selectedYear },
                success: function(response) {
                    var data = JSON.parse(response);
                    updateChart({
                        type: selectedType,
                        total: data.total,
                        desa: selectedDesa,
                        year: selectedYear,
                        kecamatanData: data.kecamatanData
                    });
                }
            });
        } else {
            // Reset to default chart if no specific filter is selected
            switch (selectedType) {
                case 'Ipald':
                    loadDefaultChart();
                    break;
                case 'Bank Sampah':
                    updateChart({
                        type: 'Bank Sampah',
                        total: {$totalDataBankSampah},
                        kecamatanData: {$kecamatanDataSampah}
                    });
                    break;
                case 'Septic Tank Individu':
                    updateChart({
                        type: 'Septic Tank Individu',
                        total: {$totalDataIndividu},
                        kecamatanData: {$kecamatanDataIndividu}
                    });
                    break;
                case 'Jembatan':
                    updateChart({
                        type: 'Jembatan',
                        total: {$totalDataJembatan},
                        kecamatanData: {$kecamatanDataJembatan}
                    });
                    break;
                case 'Hunian':
                    updateChart({
                        type: 'Hunian',
                        total: {$totalDataHunian},
                        kecamatanData: {$kecamatanDataHunian}
                    });
                    break;
                case 'Irigasi Saluran':
                    updateChart({
                        type: 'Irigasi Saluran',
                        total: {$totalDataIrigasiSaluran},
                    });
                    break;
                case 'Irigasi Bangunan':
                    updateChart({
                        type: 'Irigasi Bangunan',
                        total: {$totalDataIrigasiBangunan},
                    });
                    break;
                case 'Irigasi Terdampak':
                    updateChart({
                        type: 'Irigasi Terdampak',
                        total: {$totalDataIrigasiTerdampak},
                    });
                    break;
                case 'KPSPAMS':
                    updateChart({
                        type: 'KPSPAMS',
                        total: {$totalDataKpspams},
                        kecamatanData: {$kecamatanDataKpspams}
                    });
                    break;
                default:
                    loadDefaultChart();
                    console.error('Unknown type selected:', selectedType);
                    break;
            }
        }
        return;
    }

    $.ajax({
        url: '" . \yii\helpers\Url::to(['filter-data']) . "',
        method: 'GET',
        data: { dataType: selectedType, kodeDesa: selectedDesa, kodeKecamatan: selectedKecamatan, year: selectedYear },
        success: function(response) {
            var data = JSON.parse(response);

            // Memastikan data desa diatur jika kecamatan dipilih
            if (selectedKecamatan && data.desaData) {
                updateChart({
                    type: selectedType,
                    total: data.total,
                    desa: selectedDesa,
                    kecamatan: selectedKecamatan,
                    year: selectedYear,
                    desaData: data.desaData // Desa data diutamakan jika kecamatan dipilih
                });
            } else {
                updateChart({
                    type: selectedType,
                    total: data.total,
                    desa: selectedDesa,
                    kecamatan: selectedKecamatan,
                    year: selectedYear,
                    kecamatanData: data.kecamatanData
                });
            }
        }
    });
}


    $('#dataTypeFilter').change(function() {
        var selectedType = $(this).val();
        var desaList = [];
        var kecamatanList = [];
        var yearList = [];

        if (selectedType === 'IPALD') {
            desaList = " . json_encode($desaListIpald) . ";
            kecamatanList = " . json_encode($kecamatanListIpald) . ";
            yearList = " . json_encode($yearListIpald) . ";
        } else if (selectedType === 'Bank Sampah') {
            desaList = " . json_encode($desaListSampah) . ";
            kecamatanList = " . json_encode($kecamatanListSampah) . ";
            yearList = " . json_encode($yearListSampah) . ";
        } else if (selectedType === 'Septic Tank Individu') {
            desaList = " . json_encode($desaListIndividu) . ";
            kecamatanList = " . json_encode($kecamatanListIndividu) . ";
            yearList = " . json_encode($yearListIndividu) . ";
        } else if (selectedType === 'Jembatan') {
            desaList = " . json_encode($desaListJembatan) . ";
            kecamatanList = " . json_encode($kecamatanListJembatan) . ";
            yearList = " . json_encode($yearListJembatan) . ";
        } else if (selectedType === 'Hunian') {
            desaList = " . json_encode($desaListHunian) . ";
            kecamatanList = " . json_encode($kecamatanListHunian) . ";
            yearList = " . json_encode($yearListHunian) . ";
        } else if (selectedType === 'Irigasi Saluran') {
            desaList = " . json_encode($desaListIrigasiSaluran) . ";
            yearList = " . json_encode($yearListIrigasiSaluran) . ";
        } else if (selectedType === 'Irigasi Bangunan') {
            desaList = " . json_encode($desaListIrigasiBangunan) . ";
            yearList = " . json_encode($yearListIrigasiBangunan) . ";
        } else if (selectedType === 'Irigasi Terdampak') {
            desaList = " . json_encode($desaListIrigasiTerdampak) . ";
            yearList = " . json_encode($yearListIrigasiTerdampak) . ";
        } else if (selectedType === 'KPSPAMS') {
            desaList = " . json_encode($desaListKpspams) . ";
            yearList = " . json_encode($yearListKpspams) . ";
        }

        $('#desaFilter').empty().append('<option value=\"\">Select Desa</option>');
        $.each(desaList, function(index, value) {
            $('#desaFilter').append('<option value=\"' + value.kodeDesa + '\">' + value.kodeDesa + '</option>');
        });

        $('#kecamatanFilter').empty().append('<option value=\"\">Select Kecamatan</option>');
        $.each(kecamatanList, function(index, value) {
            $('#kecamatanFilter').append('<option value=\"' + value.kodeKecamatan + '\">' + value.kodeKecamatan + '</option>');
        });

        $('#yearFilter').empty().append('<option value=\"\">Select Year</option>');
        $.each(yearList, function(index, value) {
            $('#yearFilter').append('<option value=\"' + value + '\">' + value + '</option>');
        });

        applyFilter();
    });

    // Handle Kecamatan dropdown change
    $('#kecamatanFilter').change(function() {
        var selectedKecamatan = $(this).val();
        var selectedType = $('#dataTypeFilter').val();
        var desaList = [];
        var yearList = [];

        if (selectedKecamatan) {
            $.ajax({
                url: '" . \yii\helpers\Url::to(['desa-by-kecamatan']) . "',
                method: 'GET',
                data: { kodeKecamatan: selectedKecamatan, dataType: selectedType },
                success: function(response) {
                    desaList = JSON.parse(response);
                    $('#desaFilter').empty().append('<option value=\"\">Select Desa</option>');
                    $.each(desaList, function(index, value) {
                        $('#desaFilter').append('<option value=\"' + value.kodeDesa + '\">' + value.kodeDesa + '</option>');
                    });
                }
            });

            $.ajax({
                url: '" . \yii\helpers\Url::to(['year-by-kecamatan']) . "',
                method: 'GET',
                data: { kodeKecamatan: selectedKecamatan, dataType: selectedType },
                success: function(response) {
                    yearList = JSON.parse(response);
                    $('#yearFilter').empty().append('<option value=\"\">Select Year</option>');
                    $.each(yearList, function(index, value) {
                        $('#yearFilter').append('<option value=\"' + value + '\">' + value + '</option>');
                    });
                }
            });
        } else {
            // If no Kecamatan selected, show all Desa and Year options
            var allDesaList = [];
            var allYearList = [];
            if (selectedType === 'IPALD') {
                allDesaList = " . json_encode($desaListIpald) . ";
                allYearList = " . json_encode($yearListIpald) . ";
            } else if (selectedType === 'Bank Sampah') {
                allDesaList = " . json_encode($desaListSampah) . ";
                allYearList = " . json_encode($yearListSampah) . ";
            } else if (selectedType === 'Septic Tank Individu') {
                allDesaList = " . json_encode($desaListIndividu) . ";
                allYearList = " . json_encode($yearListIndividu) . ";
            } else if (selectedType === 'Jembatan') {
                allDesaList = " . json_encode($desaListJembatan) . ";
                allYearList = " . json_encode($yearListJembatan) . ";
            } else if (selectedType === 'Hunian') {
                allDesaList = " . json_encode($desaListHunian) . ";
                allYearList = " . json_encode($yearListHunian) . ";
            } else if (selectedType === 'Irigasi Saluran') {
                allDesaList = " . json_encode($desaListIrigasiSaluran) . ";
                allYearList = " . json_encode($yearListIrigasiSaluran) . ";
            } else if (selectedType === 'Irigasi Bangunan') {
                allDesaList = " . json_encode($desaListIrigasiBangunan) . ";
                allYearList = " . json_encode($yearListIrigasiBangunan) . ";
            } else if (selectedType === 'Irigasi Terdampak') {
                allDesaList = " . json_encode($desaListIrigasiTerdampak) . ";
                allYearList = " . json_encode($yearListIrigasiTerdampak) . ";
            } else if (selectedType === 'KPSPAMS') {
                allDesaList = " . json_encode($desaListKpspams) . ";
                allYearList = " . json_encode($yearListKpspams) . ";
            }

            $('#desaFilter').empty().append('<option value=\"\">Select Desa</option>');
            $.each(allDesaList, function(index, value) {
                $('#desaFilter').append('<option value=\"' + value.kodeDesa + '\">' + value.kodeDesa + '</option>');
            });

            $('#yearFilter').empty().append('<option value=\"\">Select Year</option>');
            $.each(allYearList, function(index, value) {
                $('#yearFilter').append('<option value=\"' + value + '\">' + value + '</option>');
            });
        }

        // Clear Desa and Year selections when Kecamatan is cleared
        $('#desaFilter').val('');
        $('#yearFilter').val('');
        applyFilter();
    });

    // Handle Desa dropdown change
    $('#desaFilter').change(applyFilter);
    $('#yearFilter').change(applyFilter);
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
                            <li class="breadcrumb-item" aria-current="page">Grafik Mutakhir</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Grafik Mutakhir</h2>
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

        <!-- <div class="row">
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



        </div> -->
        <!--  -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <h3>Data Infrastruktur</h3>
            <!-- [ Horizontal Bar Chart ] start -->
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Filter Select</h5>
                        <div class="col-lg-12">
                            <select id="dataTypeFilter" class="form-control mb-2">
                            <?php
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        $user = User::findOne(Yii::$app->user->getId());
        $allowedSkpd = ['1.04.1.03.2.11.02.0000'];

        if (isset($assignments['opd']) && in_array($user->instansi->kode_skpd, $allowedSkpd) || isset($assignments['superadmin']) || isset($assignments['admin'])) {
        ?>
                                <option value="IPALD">Data IPALD</option>
                                <option value="Septic Tank Individu">Data Septic Tank Individu</option>
                                <?php } ?>
                                <?php
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        $user = User::findOne(Yii::$app->user->getId());
        $allowedSkpd = ['1.04.1.03.2.11.02.0000', '2.11.0.00.0.00.01.0000'];

        if (isset($assignments['opd']) && in_array($user->instansi->kode_skpd, $allowedSkpd) || isset($assignments['superadmin']) || isset($assignments['admin'])) {
        ?>
                                <option value="Bank Sampah">Data Sampah</option>
                                <?php } ?>


                                <?php
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        $user = User::findOne(Yii::$app->user->getId());
        $allowedSkpd = ['1.03.0.00.0.00.01.0000'];

        if (isset($assignments['opd']) && in_array($user->instansi->kode_skpd, $allowedSkpd) || isset($assignments['superadmin']) || isset($assignments['admin'])) {
        ?>
                                <option value="Jembatan">Data Jembatan</option>
                                <option value="Irigasi Saluran">Data Irigasi Saluran</option>
                                <option value="Irigasi Bangunan">Data Irigasi Bangunan</option>
                                <option value="Irigasi Terdampak">Data Irigasi Terdampak</option>
                                <?php } ?>
                                <?php
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        $user = User::findOne(Yii::$app->user->getId());
        $allowedSkpd = ['1.04.2.10.0.00.01.0000'];

        if (isset($assignments['opd']) && in_array($user->instansi->kode_skpd, $allowedSkpd) || isset($assignments['superadmin']) || isset($assignments['admin'])) {
        ?>
                                <option value="Hunian">Data Hunian</option>
                                <?php } ?>
                                <?php
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        $user = User::findOne(Yii::$app->user->getId());
        $allowedSkpd = ['1.04.1.03.2.11.02.0000'];

        if (isset($assignments['opd']) && in_array($user->instansi->kode_skpd, $allowedSkpd) || isset($assignments['superadmin']) || isset($assignments['admin'])) {
        ?>
                                <option value="KPSPAMS">Data KPSPAMS</option>
                                <?php } ?>
                            </select>
                            <select id="kecamatanFilter" class="form-control mb-2">
                                <option value="">Select Kecamatan</option>
                                <?php foreach ($kecamatanListIpald as $kecamatan) : ?>
                                    <option value="<?= $kecamatan['kodeKecamatan'] ?>"><?= $kecamatan['kodeKecamatan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select id="desaFilter" class="form-control mb-2">
                                <option value="">Select Desa</option>
                                <?php foreach ($desaListIpald as $desa) : ?>
                                    <option value="<?= $desa['kodeDesa'] ?>"><?= $desa['kodeDesa'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select id="yearFilter" class="form-control">
                                <option value="">Select Year</option>
                                <?php foreach ($yearListIpald as $year) : ?>
                                    <option value="<?= htmlspecialchars($year) ?>"><?= htmlspecialchars($year) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <div class="card-body">
                            <div id="barChart" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- [ Horizontal Bar Chart ] end -->
        </div>
        <!-- [ Main Content ] end -->


    </div>
    <!-- [ Main Content ] end -->
</div>
</div>
<!-- [ Main Content ] end -->