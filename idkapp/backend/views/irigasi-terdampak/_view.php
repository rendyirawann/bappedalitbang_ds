<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TblSampah */

$this->title = 'Detail Data Irigasi Terdampak';
$this->params['breadcrumbs'][] = ['label' => 'Detail Data Irigasi Terdampak', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="irigasi-terdampak-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="dt-responsive table-responsive mt-2">
        <table id="table-style-hover" class="table table-striped table-hover table-bordered nowrap" style="font-size:small;">
            <thead>
                <tr>
                    <th rowspan="3">No</th>
                    <th rowspan="3">Nomeklatur</th>
                    <th rowspan="3">Desa</th>
                    <th rowspan="3">Luas Daerah Irigasi Sesuai Permen 14/2015 (Ha)</th>
                    <th colspan="5" style="text-align: center;">Areal Terdampak Kondisi Jaringan Irigasi (Ha)</th>
                </tr>
                <tr style="text-align: center;">
                    <th>Baik(Ha)</th>
                    <th>Rusak Ringan(Ha)</th>
                    <th>Rusak Sedang(Ha)</th>
                    <th>Rusak Berat(Ha)</th>
                    <th>Total(Ha)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><?= Html::encode($model->nomeklatur) ?></td>
                    <td><?= Html::encode($model->kodeDesa) ?></td>
                    <td style="text-align: center;"><?= Html::encode($model->luasIrigasi) ?> Ha</td>
                    <td style="text-align: center;"><?= Html::encode($model->arealBaik) ?> Ha</td>
                    <td style="text-align: center;"><?= Html::encode($model->arealRusakRingan) ?> Ha</td>
                    <td style="text-align: center;"><?= Html::encode($model->arealRusakSedang) ?> Ha</td>
                    <td style="text-align: center;"><?= Html::encode($model->arealRusakBerat) ?> Ha</td>
                    <td style="text-align: center;"><?= Html::encode($model->total) ?> Ha</td>

                </tr>
            </tbody>
        </table>
    </div>



</div>