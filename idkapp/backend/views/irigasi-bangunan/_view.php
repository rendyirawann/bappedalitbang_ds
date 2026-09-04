<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Irigasi Bangunan';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Irigasi Bangunan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="irigasi-bangunan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="dt-responsive table-responsive mt-2">
        <table id="table-style-hover" class="table table-striped table-hover table-bordered nowrap" style="font-size:medium;">
            <thead>
                <tr>
                    <th rowspan="4">No</th>
                    <th rowspan="4">Nomeklatur</th>
                    <th rowspan="4">Desa</th>
                    <th rowspan="4">Luas</th>
                    <th colspan="12" style="text-align: center;">Kondisi Fisik Bangunan Irigasi Permukaan</th>
                    <th colspan="2" rowspan="2">Rata-Rata Kondisi Bangunan</th>
                    <th rowspan="4">Keterangan</th>
                </tr>
                <tr>
                    <th colspan="2">Bangunan Utama</th>
                    <th colspan="2">Bangunan Pengatur dan Pengukur</th>
                    <th colspan="2">Bangunan Pembawa</th>
                    <th colspan="2">Bangunan Lindung</th>
                    <th colspan="2">Bangunan Pelengkap</th>
                    <th colspan="2">Sarana</th>
                </tr>
                <tr>
                    <th>B/RR/RS/RB</th>
                    <th>Nilai Kondisi (%)</th>
                    <th>B/RR/RS/RB</th>
                    <th>Nilai Kondisi (%)</th>
                    <th>B/RR/RS/RB</th>
                    <th>Nilai Kondisi (%)</th>
                    <th>B/RR/RS/RB</th>
                    <th>Nilai Kondisi (%)</th>
                    <th>B/RR/RS/RB</th>
                    <th>Nilai Kondisi (%)</th>
                    <th>B/RR/RS/RB</th>
                    <th>Nilai Kondisi (%)</th>
                    <th>B/RR/RS/RB</th>
                    <th>Nilai Kondisi (%)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><?= Html::encode($model->nomeklatur) ?></td>
                    <td><?= Html::encode($model->kodeDesa) ?></td>
                    <td><?= Html::encode($model->luasIrigasi) ?> Ha</td>
                    <td><?= Html::encode($model->bgnUtamaStatus) ?></td>
                    <td><?= Html::encode($model->bgnUtamaKondisi) ?> %</td>
                    <td><?= Html::encode($model->bgnPengaturPengukurStatus) ?></td>
                    <td><?= Html::encode($model->bgnPengaturPengukurKondisi) ?> %</td>
                    <td><?= Html::encode($model->bgnPembawaStatus) ?></td>
                    <td><?= Html::encode($model->bgnPembawaKondisi) ?> %</td>
                    <td><?= Html::encode($model->bgnLindungStatus) ?></td>
                    <td><?= Html::encode($model->bgnLindungKondisi) ?> %</td>
                    <td><?= Html::encode($model->bgnPelengkapStatus) ?></td>
                    <td><?= Html::encode($model->bgnPelengkapKondisi) ?> %</td>
                    <td><?= Html::encode($model->saranaStatus) ?></td>
                    <td><?= Html::encode($model->saranaKondisi) ?> %</td>
                    <td><?= Html::encode($model->rataStatus) ?></td>
                    <td><?= Html::encode($model->rataKondisi) ?> %</td>
                    <td><?= Html::encode($model->keterangan) ?></td>
                </tr>
            </tbody>
        </table>
    </div>




</div>