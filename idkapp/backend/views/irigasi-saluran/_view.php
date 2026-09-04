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
<div class="irigasi-saluran-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="dt-responsive table-responsive mt-2">
        <table id="table-style-hover" class="table table-striped table-hover table-bordered nowrap" style="font-size:medium;">
            <thead>
                <tr>
                    <th rowspan="3">Nomor</th>
                    <th rowspan="3">Nomeklatur</th>
                    <th rowspan="3">Desa</th>
                    <th rowspan="3">Luas D.I Sesuai Permen 14/15 (Ha)</th>
                    <th rowspan="3">Sawah/Fungsional (Pemetaan IGT) (Ha)</th>
                    <th colspan="12" style="text-align: center;">Saluran</th>
                    <th colspan="18">Bangunan</th>
                    <th colspan="2" rowspan="2">Rata-Rata Jaringan</th>
                    <th colspan="5">Areal Terdampak Kondisi Jaringan Irigasi Permukaan (Ha)</th>
                    <th colspan="8">Indeks Kinerja Sistem Irigasi Permukaan (%)</th>
                    <th rowspan="3">Keterangan</th>
                    <th rowspan="3">Tahun</th>
                </tr>
                <tr>
                    <th colspan="5">Saluran Primer</th>
                    <th colspan="5">Saluran Sekunder</th>
                    <th colspan="2">Saluran Pembuang</th>
                    <th colspan="2">Bagi**</th>
                    <th colspan="2">Bagi Sadap**</th>
                    <th colspan="2">Sadap**</th>
                    <th colspan="2">Pintu Air**</th>
                    <th colspan="2">Talang**</th>
                    <th colspan="2">Sipon**</th>
                    <th colspan="2">Gorong**</th>
                    <th colspan="2">Terjun**</th>
                    <th colspan="2">Tanggul**</th>
                    <th rowspan="2">Baik (Ha)</th>
                    <th rowspan="2">Rusak Ringan (Ha)</th>
                    <th rowspan="2">Rusak Sedang (Ha)</th>
                    <th rowspan="2">Rusak Berat (Ha)</th>
                    <th rowspan="2">Total (Ha)</th>
                    <th>Prasarana Fisik</th>
                    <th>Produktivitas</th>
                    <th>Sarana Penunjang</th>
                    <th>Organisasi Personalia</th>
                    <th>Dokumentasi</th>
                    <th>P3A/GP3A/IP3A</th>
                    <th>Jumlah</th>
                    <th rowspan="2">Kategori (SB/B/K/J)</th>
                </tr>
                <tr>
                    <th>B/RR/RS/RB</th>
                    <th>% Kondisi Baik</th>
                    <th>% Kondisi Baik</th>
                    <th>Total Panjang Saluran (m)</th>
                    <th>Saluran Kondisi Baik (m)</th>
                    <th>B/RR/RS/RB</th>
                    <th>% Kondisi Baik</th>
                    <th>% Kondisi Baik</th>
                    <th>Total Panjang Saluran (m)</th>
                    <th>Saluran Kondisi Baik (m)</th>
                    <th>B/RR/RS/RB</th>
                    <th>% Kondisi Baik</th>
                    <th>B/RR/RS/RB</th>
                    <th>% Kondisi Baik</th>
                    <th>B/RR/RS/RB</th>
                    <th>% Kondisi Baik</th>
                    <th>B/RR/RS/RB</th>
                    <th>% Kondisi Baik</th>
                    <th>B/RR/RS/RB</th>
                    <th>% Kondisi Baik</th>
                    <th>B/RR/RS/RB</th>
                    <th>% Kondisi Baik</th>
                    <th>B/RR/RS/RB</th>
                    <th>% Kondisi Baik</th>
                    <th>B/RR/RS/RB</th>
                    <th>% Kondisi Baik</th>
                    <th>B/RR/RS/RB</th>
                    <th>% Kondisi Baik</th>
                    <th>B/RR/RS/RB</th>
                    <th>% Kondisi Baik</th>
                    <th>B/RR/RS/RB</th>
                    <th>% Kondisi Baik</th>
                    <th>Nilai Maks 45%</th>
                    <th>Nilai Maks 15%</th>
                    <th>Nilai Maks 10%</th>
                    <th>Nilai Maks 15%</th>
                    <th>Nilai Maks 5%</th>
                    <th>Nilai Maks 10%</th>
                    <th>Nilai Maks 100%</th>
                </tr>

            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><?= Html::encode($model->nomeklatur) ?></td>
                    <td><?= Html::encode($model->kodeDesa) ?></td>
                    <td><?= Html::encode($model->luasIrigasi) ?></td>
                    <td><?= Html::encode($model->igt) ?></td>
                    <td><?= Html::encode($model->primerSaluranStatus) ?></td>
                    <td><?= Html::encode($model->primerKondisiBaik) ?></td>
                    <td><?= Html::encode($model->primerKondisiBaik) ?></td>
                    <td><?= Html::encode($model->primerPjgSaluran) ?></td>
                    <td><?= Html::encode($model->primerSaluranBaik) ?></td>
                    <td><?= Html::encode($model->sekunderSaluranStatus) ?></td>
                    <td><?= Html::encode($model->sekunderKondisiBaik) ?></td>
                    <td><?= Html::encode($model->sekunderKondisiBaik) ?></td>
                    <td><?= Html::encode($model->sekunderPjgSaluran) ?></td>
                    <td><?= Html::encode($model->sekunderSaluranBaik) ?></td>
                    <td><?= Html::encode($model->pembuangKondisiBaik) ?></td>
                    <td><?= Html::encode($model->pembuangSaluranStatus) ?></td>
                    <td><?= Html::encode($model->bangunanBagiKondisiBaik) ?></td>
                    <td><?= Html::encode($model->bangunanBagiStatus) ?></td>
                    <td><?= Html::encode($model->bangunanBagiSadapKondisiBaik) ?></td>
                    <td><?= Html::encode($model->bangunanBagiSadapStatus) ?></td>
                    <td><?= Html::encode($model->bangunanSadapKondisiBaik) ?></td>
                    <td><?= Html::encode($model->bangunanSadapStatus) ?></td>
                    <td><?= Html::encode($model->bangunanPintuAirKondisiBaik) ?></td>
                    <td><?= Html::encode($model->bangunanPintuAirStatus) ?></td>
                    <td><?= Html::encode($model->bangunanTalangKondisiBaik) ?></td>
                    <td><?= Html::encode($model->bangunanTalangStatus) ?></td>
                    <td><?= Html::encode($model->bangunanSiponKondisiBaik) ?></td>
                    <td><?= Html::encode($model->bangunanSiponStatus) ?></td>
                    <td><?= Html::encode($model->bangunanGorongKondisiBaik) ?></td>
                    <td><?= Html::encode($model->bangunanGorongStatus) ?></td>
                    <td><?= Html::encode($model->bangunanTerjunKondisiBaik) ?></td>
                    <td><?= Html::encode($model->bangunanTerjunStatus) ?></td>
                    <td><?= Html::encode($model->bangunanTanggulKondisiBaik) ?></td>
                    <td><?= Html::encode($model->bangunanTanggulStatus) ?></td>
                    <td><?= Html::encode($model->rataJaringanKondisiBaik) ?></td>
                    <td><?= Html::encode($model->rataJaringanStatus) ?></td>
                    <td><?= Html::encode($model->arealBaik) ?></td>
                    <td><?= Html::encode($model->arealRusakRingan) ?></td>
                    <td><?= Html::encode($model->arealRusakSedang) ?></td>
                    <td><?= Html::encode($model->arealRusakBerat) ?></td>
                    <td><?= Html::encode($model->arealTotal) ?></td>
                    <td><?= Html::encode($model->indeksPrasaranaFisik) ?></td>
                    <td><?= Html::encode($model->indeksProduktivitas) ?></td>
                    <td><?= Html::encode($model->indeksSaranaPenunjang) ?></td>
                    <td><?= Html::encode($model->indeksOrganisasiPersonalia) ?></td>
                    <td><?= Html::encode($model->indeksDokumentasi) ?></td>
                    <td><?= Html::encode($model->indeksPpa) ?></td>
                    <td><?= Html::encode($model->indeksJumlah) ?></td>
                    <td><?= Html::encode($model->indeksKategori) ?></td>
                    <td><?= Html::encode($model->keterangan) ?></td>
                    <td><?= Html::encode($model->kodeTahun) ?></td>
                </tr>
            </tbody>
        </table>
    </div>




</div>