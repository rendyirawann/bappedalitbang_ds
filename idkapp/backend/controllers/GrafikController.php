<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\assets\LeafletAsset;
use backend\assets\AppAsset;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use backend\models\AsetIpald;
use backend\models\AsetSampah;
use backend\models\BidangIpald;
use backend\models\DanaIpald;
use backend\models\DanaSampah;
use backend\models\DanaSepticIndividu;
use backend\models\DataDesa;
use backend\models\DataIndividu;
use backend\models\DataIpald;
use backend\models\DataJalan;
use backend\models\DataJembatan;
use backend\models\DataKecamatan;
use backend\models\DataPengelola;
use backend\models\DataSampah;
use backend\models\DataHunian;
use backend\models\DataKpspams;
use backend\models\IrigasiSaluran;
use backend\models\IrigasiBangunan;
use backend\models\IrigasiTerdampak;
use backend\models\User;
use backend\models\IpaldDokumen;
use backend\models\JembatanDokumen;
use backend\models\KeteranganJembatan;
use backend\models\SampahDokumen;
use backend\models\StatusAset;
use backend\models\TahunJembatan;
use backend\models\TahunSepticTankIndividu;
use backend\models\TblDokumenIpald;
use backend\models\TblDokumenSampah;
use backend\models\TblIndividu2021;
use backend\models\TblIndividu2022;
use backend\models\TblIndividu2023;
use backend\models\TblIpald;
use backend\models\TblJembatan2022;
use backend\models\TblJembatan2023;
use backend\models\TblSampah;
use backend\models\UploadDataDesa;
use backend\models\UploadDataIpald;
use backend\models\UploadDataJalan;
use backend\models\UploadDataJembatan;
use backend\models\UploadDataKecamatan;
use backend\models\UploadDataSampah;
use backend\models\UploadDataSepticTankIndividu;
use backend\models\UploadFormIndividu2021;
use backend\models\UploadFormIndividu2022;
use backend\models\UploadFormIndividu2023;
use backend\models\UploadFormIpald;
use backend\models\UploadFormJembatan2022;
use backend\models\UploadFormJembatan2023;
use backend\models\UploadFormSampah;

class GrafikController extends Controller
{

    public function actionIndex()
    {
        $totalDataBankSampah = DataSampah::find()->count();
        $totalDataIpald = DataIpald::find()->count();
        $totalDataIndividu = DataIndividu::find()->count();
        $totalDataJembatan = DataJembatan::find()->count();
        $totalDataHunian = DataHunian::find()->count();
        $totalDataKpspams = DataKpspams::find()->count();

        $totalDataIrigasiSaluran = IrigasiSaluran::find()->count();
        $totalDataIrigasiBangunan = IrigasiBangunan::find()->count();
        $totalDataIrigasiTerdampak = IrigasiTerdampak::find()->count();
        $totalDataIrigasi = $totalDataIrigasiSaluran + $totalDataIrigasiBangunan + $totalDataIrigasiTerdampak;


        // Prepare data for pie chart (status distribution of data_sampah)
        $statusCounts = DataSampah::find()
            ->select(['status', 'COUNT(*) AS count'])
            ->groupBy('status')
            ->asArray()
            ->all();

        // Prepare data for line chart (tahunPembangunan trend in data_sampah)
        $tahunPembangunanCounts = DataSampah::find()
            ->select(['tahunPembangunan', 'COUNT(*) AS count'])
            ->groupBy('tahunPembangunan')
            ->orderBy('tahunPembangunan')
            ->asArray()
            ->all();

        // Prepare data for bar chart (data_jembatan by tahun)
        $jembatanTahunCounts = DataJembatan::find()
            ->select(['tahun', 'COUNT(*) AS count'])
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->asArray()
            ->all();

        // Prepare data for stacked bar chart (nilai comparison in data_jembatan)
        $nilaiData = DataJembatan::find()
            ->select(['namaPekerjaan', 'nilaiPagu', 'nilaiKontrak', 'nilaiAddendum'])
            ->asArray()
            ->all();

        // Get current year and last year
        $currentYear = date('Y');
        $lastYear = $currentYear - 1;

        // Count irigasi data for current year and last year
        $currentYearCountIrigasi = IrigasiSaluran::find()->where(['kodeTahun' => $currentYear])->count()
            + IrigasiBangunan::find()->where(['kodeTahun' => $currentYear])->count()
            + IrigasiTerdampak::find()->where(['kodeTahun' => $currentYear])->count();

        $lastYearCountIrigasi = IrigasiSaluran::find()->where(['kodeTahun' => $lastYear])->count()
            + IrigasiBangunan::find()->where(['kodeTahun' => $lastYear])->count()
            + IrigasiTerdampak::find()->where(['kodeTahun' => $lastYear])->count();

        // Count data_sampah for current year and last year
        $currentYearCount = DataSampah::find()
            ->where(['tahunPembangunan' => $currentYear])
            ->count();

        $lastYearCount = DataSampah::find()
            ->where(['tahunPembangunan' => $lastYear])
            ->count();

        // Count data_ipald for current year and last year
        $currentYearCountIpald = DataIpald::find()
            ->where(['tahunPembangunan' => $currentYear])
            ->count();

        $lastYearCountIpald = DataIpald::find()
            ->where(['tahunPembangunan' => $lastYear])
            ->count();

        // Count data_individu for current year and last year
        $currentYearCountIndividu = DataIndividu::find()
            ->where(['kodeTahun' => $currentYear])
            ->count();

        $lastYearCountIndividu = DataIndividu::find()
            ->where(['kodeTahun' => $lastYear])
            ->count();

        // Count data_jembatan for current year and last year
        $currentYearCountJembatan = DataJembatan::find()
            ->where(['tahun' => $currentYear])
            ->count();

        $lastYearCountJembatan = DataJembatan::find()
            ->where(['tahun' => $lastYear])
            ->count();

        // Count data_hunian for current year and last year
        $currentYearCountHunian = DataHunian::find()
            ->where(['kodeTahun' => $currentYear])
            ->count();

        $lastYearCountHunian = DataHunian::find()
            ->where(['kodeTahun' => $lastYear])
            ->count();

        // Count data_kpspams for current year and last year
        $currentYearCountKpspams = DataKpspams::find()
            ->where(['kodeTahun' => $currentYear])
            ->count();

        $lastYearCountKpspams = DataKpspams::find()
            ->where(['kodeTahun' => $lastYear])
            ->count();

        // Get unique kodeDesa and kodeKecamatan values for IPALD
        $desaListIpald = DataIpald::find()
            ->select(['kodeDesa'])
            ->distinct()
            ->asArray()
            ->all();
        $kecamatanListIpald = DataIpald::find()
            ->select(['kodeKecamatan'])
            ->distinct()
            ->asArray()
            ->all();


        // Get data grouped by kecamatan for IPALD
        $kecamatanDataIpald = DataIpald::find()
            ->select(['kodeKecamatan', 'COUNT(*) AS total'])
            ->groupBy('kodeKecamatan')
            ->asArray()
            ->all();

        // Get data grouped by desa for IPALD
        $desaDataIpald = DataIpald::find()
        ->select(['kodeDesa', 'COUNT(*) AS total'])
        ->groupBy('kodeDesa')
        ->asArray()
        ->all();

        // Get unique kodeDesa and kodeKecamatan values for Bank Sampah
        $desaListSampah = DataSampah::find()
            ->select(['kodeDesa'])
            ->distinct()
            ->asArray()
            ->all();
        $kecamatanListSampah = DataSampah::find()
            ->select(['kodeKecamatan'])
            ->distinct()
            ->asArray()
            ->all();

        // Get data grouped by kecamatan for Bank Sampah
        $kecamatanDataSampah = DataSampah::find()
            ->select(['kodeKecamatan', 'COUNT(*) AS total'])
            ->groupBy('kodeKecamatan')
            ->asArray()
            ->all();

        // Get data grouped by desa for Bank Sampah
        $desaDataSampah = DataSampah::find()
            ->select(['kodeDesa', 'COUNT(*) AS total'])
            ->groupBy('kodeDesa')
            ->asArray()
            ->all();

        // Get unique kodeDesa and kodeKecamatan values for Septic Tank Individu
        $desaListIndividu = DataIndividu::find()
            ->select(['kodeDesa'])
            ->distinct()
            ->asArray()
            ->all();
        $kecamatanListIndividu = DataIndividu::find()
            ->select(['kodeKecamatan'])
            ->distinct()
            ->asArray()
            ->all();

        // Get data grouped by kecamatan for Individu
        $kecamatanDataIndividu = DataIndividu::find()
            ->select(['kodeKecamatan', 'COUNT(*) AS total'])
            ->groupBy('kodeKecamatan')
            ->asArray()
            ->all();

            // Get data grouped by desa for Individu
            $desaDataIndividu = DataIndividu::find()
            ->select(['kodeDesa', 'COUNT(*) AS total'])
            ->groupBy('kodeDesa')
            ->asArray()
            ->all();

        // Get unique kodeDesa and kodeKecamatan values for Jembatan
        $desaListJembatan = DataJembatan::find()
            ->select(['kodeDesa'])
            ->distinct()
            ->asArray()
            ->all();
        $kecamatanListJembatan = DataJembatan::find()
            ->select(['kodeKecamatan'])
            ->distinct()
            ->asArray()
            ->all();

        // Get data grouped by kecamatan for Jembatan
        $kecamatanDataJembatan = DataJembatan::find()
            ->select(['kodeKecamatan', 'COUNT(*) AS total'])
            ->groupBy('kodeKecamatan')
            ->asArray()
            ->all();

        // Get data grouped by desa for Jembatan
        $desaDataJembatan = DataJembatan::find()
            ->select(['kodeDesa', 'COUNT(*) AS total'])
            ->groupBy('kodeDesa')
            ->asArray()
            ->all();

        // Get unique kodeDesa and kodeKecamatan values for Hunian
        $desaListHunian = DataHunian::find()
            ->select(['kodeDesa'])
            ->distinct()
            ->asArray()
            ->all();
        $kecamatanListHunian = DataHunian::find()
            ->select(['kodeKecamatan'])
            ->distinct()
            ->asArray()
            ->all();

        // Get data grouped by kecamatan for Hunian
        $kecamatanDataHunian = DataHunian::find()
            ->select(['kodeKecamatan', 'COUNT(*) AS total'])
            ->groupBy('kodeKecamatan')
            ->asArray()
            ->all();

        // Get data grouped by desa for Hunian
        $desaDataHunian = DataHunian::find()
            ->select(['kodeDesa', 'COUNT(*) AS total'])
            ->groupBy('kodeDesa')
            ->asArray()
            ->all();

        // Get unique kodeDesa and kodeKecamatan values for Irigasi Saluran
        $desaListIrigasiSaluran = IrigasiSaluran::find()
            ->select(['kodeDesa'])
            ->distinct()
            ->asArray()
            ->all();

        // Get unique kodeDesa and kodeKecamatan values for Irigasi Bangunan
        $desaListIrigasiBangunan = IrigasiBangunan::find()
            ->select(['kodeDesa'])
            ->distinct()
            ->asArray()
            ->all();

        // Get unique kodeDesa and kodeKecamatan values for Irigasi Terdampak
        $desaListIrigasiTerdampak = IrigasiTerdampak::find()
            ->select(['kodeDesa'])
            ->distinct()
            ->asArray()
            ->all();

        // Get unique kodeDesa and kodeKecamatan values for KPSPAMS
        $desaListKpspams = DataKpspams::find()
            ->select(['kodeDesa'])
            ->distinct()
            ->asArray()
            ->all();
        $kecamatanListKpspams = DataKpspams::find()
            ->select(['kodeKecamatan'])
            ->distinct()
            ->asArray()
            ->all();

        // Get data grouped by kecamatan for KPSPAMS
        $kecamatanDataKpspams = DataKpspams::find()
            ->select(['kodeKecamatan', 'COUNT(*) AS total'])
            ->groupBy('kodeKecamatan')
            ->asArray()
            ->all();

        // Get data grouped by desa for KPSPAMS
        $desaDataKpspams = DataKpspams::find()
            ->select(['kodeDesa', 'COUNT(*) AS total'])
            ->groupBy('kodeDesa')
            ->asArray()
            ->all();

        $yearListIpald = DataIpald::find()->select('tahunPembangunan')->distinct()->column();
        $yearListSampah = DataSampah::find()->select('tahunPembangunan')->distinct()->column();
        $yearListIndividu = DataIndividu::find()->select('kodeTahun')->distinct()->column();
        $yearListJembatan = DataJembatan::find()->select('tahun')->distinct()->column();
        $yearListHunian = DataHunian::find()->select('kodeTahun')->distinct()->column();
        $yearListIrigasiSaluran = IrigasiSaluran::find()->select('kodeTahun')->distinct()->column();
        $yearListIrigasiBangunan = IrigasiBangunan::find()->select('kodeTahun')->distinct()->column();
        $yearListIrigasiTerdampak = IrigasiTerdampak::find()->select('kodeTahun')->distinct()->column();
        $yearListKpspams = DataKpspams::find()->select('kodeTahun')->distinct()->column();


        return $this->render('index', [
            'totalDataBankSampah' => $totalDataBankSampah,
            'totalDataIpald' => $totalDataIpald,
            'totalDataIndividu' => $totalDataIndividu,
            'totalDataJembatan' => $totalDataJembatan,
            'totalDataHunian' => $totalDataHunian,
            'totalDataIrigasi' => $totalDataIrigasi,
            'totalDataIrigasiSaluran' => $totalDataIrigasiSaluran,
            'totalDataIrigasiBangunan' => $totalDataIrigasiBangunan,
            'totalDataIrigasiTerdampak' => $totalDataIrigasiTerdampak,
            'totalDataKpspams' => $totalDataKpspams,
            'statusCounts' => $statusCounts,
            'tahunPembangunanCounts' => $tahunPembangunanCounts,
            'jembatanTahunCounts' => $jembatanTahunCounts,
            'nilaiData' => $nilaiData,
            'currentYearCount' => $currentYearCount,
            'lastYearCount' => $lastYearCount,
            'currentYearCountIpald' => $currentYearCountIpald,
            'lastYearCountIpald' => $lastYearCountIpald,
            'currentYearCountIndividu' => $currentYearCountIndividu,
            'lastYearCountIndividu' => $lastYearCountIndividu,
            'currentYearCountJembatan' => $currentYearCountJembatan,
            'lastYearCountJembatan' => $lastYearCountJembatan,
            'currentYearCountHunian' => $currentYearCountHunian,
            'lastYearCountHunian' => $lastYearCountHunian,
            'currentYearCountIrigasi' => $currentYearCountIrigasi,
            'lastYearCountIrigasi' => $lastYearCountIrigasi,
            'currentYearCountKpspams' => $currentYearCountKpspams,
            'lastYearCountKpspams' => $lastYearCountKpspams,
            'desaListIpald' => $desaListIpald,
            'kecamatanListIpald' => $kecamatanListIpald,
            'desaListSampah' => $desaListSampah,
            'kecamatanListSampah' => $kecamatanListSampah,
            'desaListIndividu' => $desaListIndividu,
            'kecamatanListIndividu' => $kecamatanListIndividu,
            'desaListJembatan' => $desaListJembatan,
            'kecamatanListJembatan' => $kecamatanListJembatan,
            'desaListHunian' => $desaListHunian,
            'kecamatanListHunian' => $kecamatanListHunian,
            'desaListIrigasiSaluran' => $desaListIrigasiSaluran,
            'desaListIrigasiBangunan' => $desaListIrigasiBangunan,
            'desaListIrigasiTerdampak' => $desaListIrigasiTerdampak,
            'desaListKpspams' => $desaListKpspams,
            'kecamatanListKpspams' => $kecamatanListKpspams,
            'yearListIpald' => $yearListIpald,
            'yearListSampah' => $yearListSampah,
            'yearListIndividu' => $yearListIndividu,
            'yearListJembatan' => $yearListJembatan,
            'yearListHunian' => $yearListHunian,
            'yearListIrigasiSaluran' => $yearListIrigasiSaluran,
            'yearListIrigasiBangunan' => $yearListIrigasiBangunan,
            'yearListIrigasiTerdampak' => $yearListIrigasiTerdampak,
            'yearListIrigasiBangunan' => $yearListIrigasiBangunan,
            'yearListKpspams' => $yearListKpspams,
            'kecamatanDataIpald' => json_encode($kecamatanDataIpald),
            'kecamatanDataSampah' => json_encode($kecamatanDataSampah),
            'kecamatanDataIndividu' => json_encode($kecamatanDataIndividu),
            'kecamatanDataJembatan' => json_encode($kecamatanDataJembatan),
            'kecamatanDataHunian' => json_encode($kecamatanDataHunian),
            'kecamatanDataKpspams' => json_encode($kecamatanDataKpspams),
            'desaDataIpald' => json_encode($desaDataIpald),
            'desaDataSampah' => json_encode($desaDataSampah),
            'desaDataIndividu' => json_encode($desaDataIndividu),
            'desaDataJembatan' => json_encode($desaDataJembatan),
            'desaDataHunian' => json_encode($desaDataHunian),
            'desaDataKpspams' => json_encode($desaDataKpspams),
        ]);
    }

    public function actionFilterData()
{
    $dataType = Yii::$app->request->get('dataType');
    $kodeDesa = Yii::$app->request->get('kodeDesa');
    $kodeKecamatan = Yii::$app->request->get('kodeKecamatan');
    $year = Yii::$app->request->get('year');

    $query = null;

    if ($dataType === 'IPALD') {
        $query = DataIpald::find();
        if ($year) {
            $query->andWhere(['tahunPembangunan' => $year]);
        }
    } else if ($dataType === 'Bank Sampah') {
        $query = DataSampah::find();
        if ($year) {
            $query->andWhere(['tahunPembangunan' => $year]);
        }
    } else if ($dataType === 'Septic Tank Individu') {
        $query = DataIndividu::find();
        if ($year) {
            $query->andWhere(['kodeTahun' => $year]);
        }
    } else if ($dataType === 'Jembatan') {
        $query = DataJembatan::find();
        if ($year) {
            $query->andWhere(['tahun' => $year]);
        }
    } else if ($dataType === 'Hunian') {
        $query = DataHunian::find();
        if ($year) {
            $query->andWhere(['kodeTahun' => $year]);
        }
    } else if ($dataType === 'Irigasi Saluran') {
        $query = IrigasiSaluran::find();
        if ($year) {
            $query->andWhere(['kodeTahun' => $year]);
        }
    } else if ($dataType === 'Irigasi Bangunan') {
        $query = IrigasiBangunan::find();
        if ($year) {
            $query->andWhere(['kodeTahun' => $year]);
        }
    } else if ($dataType === 'Irigasi Terdampak') {
        $query = IrigasiTerdampak::find();
        if ($year) {
            $query->andWhere(['kodeTahun' => $year]);
        }
    } else if ($dataType === 'KPSPAMS') {
        $query = DataKpspams::find();
        if ($year) {
            $query->andWhere(['kodeTahun' => $year]);
        }
    }

    if ($kodeDesa) {
        $query->andWhere(['kodeDesa' => $kodeDesa]);
    }
    if ($kodeKecamatan) {
        $query->andWhere(['kodeKecamatan' => $kodeKecamatan]);
    }

    $total = $query->count();

    // Jika kodeKecamatan dipilih, ambil data berdasarkan desa di kecamatan tersebut
    if ($kodeKecamatan) {
        $desaData = $query
            ->select(['kodeDesa', 'COUNT(*) AS total'])
            ->groupBy('kodeDesa')
            ->asArray()
            ->all();

        return json_encode([
            'total' => $total,
            'desaData' => $desaData
        ]);
    } else {
        // Jika tidak ada kecamatan, ambil data kecamatan
        $kecamatanData = $query
            ->select(['kodeKecamatan', 'COUNT(*) AS total'])
            ->groupBy('kodeKecamatan')
            ->asArray()
            ->all();

        return json_encode([
            'total' => $total,
            'kecamatanData' => $kecamatanData
        ]);
    }
}



    public function actionDesaByKecamatan()
    {
        $kodeKecamatan = Yii::$app->request->get('kodeKecamatan');
        $dataType = Yii::$app->request->get('dataType');

        $desaList = [];
        if ($dataType === 'IPALD') {
            $desaList = DataIpald::find()
                ->select(['kodeDesa'])
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->asArray()
                ->all();
        } elseif ($dataType === 'Bank Sampah') {
            $desaList = DataSampah::find()
                ->select(['kodeDesa'])
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->asArray()
                ->all();
        } elseif ($dataType === 'Septic Tank Individu') {
            $desaList = DataIndividu::find()
                ->select(['kodeDesa'])
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->asArray()
                ->all();
        } elseif ($dataType === 'Jembatan') {
            $desaList = DataJembatan::find()
                ->select(['kodeDesa'])
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->asArray()
                ->all();
        } elseif ($dataType === 'Hunian') {
            $desaList = DataHunian::find()
                ->select(['kodeDesa'])
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->asArray()
                ->all();
        } elseif ($dataType === 'Irigasi Saluran') {
            $desaList = IrigasiSaluran::find()
                ->select(['kodeDesa'])
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->asArray()
                ->all();
        } elseif ($dataType === 'Irigasi Bangunan') {
            $desaList = IrigasiBangunan::find()
                ->select(['kodeDesa'])
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->asArray()
                ->all();
        } elseif ($dataType === 'Irigasi Terdampak') {
            $desaList = IrigasiTerdampak::find()
                ->select(['kodeDesa'])
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->asArray()
                ->all();
        } elseif ($dataType === 'KPSPAMS') {
            $desaList = DataKpspams::find()
                ->select(['kodeDesa'])
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->asArray()
                ->all();
        }

        return \yii\helpers\Json::encode($desaList);
    }

    public function actionYearByKecamatan()
    {
        $kodeKecamatan = Yii::$app->request->get('kodeKecamatan');
        $dataType = Yii::$app->request->get('dataType');

        $yearList = [];

        if ($dataType === 'IPALD') {
            $yearList = DataIpald::find()
                ->select('tahunPembangunan')
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->column();
        } else if ($dataType === 'Bank Sampah') {
            $yearList = DataSampah::find()
                ->select('tahunPembangunan')
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->column();
        } else if ($dataType === 'Septic Tank Individu') {
            $yearList = DataIndividu::find()
                ->select('kodeTahun')
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->column();
        } else if ($dataType === 'Jembatan') {
            $yearList = DataJembatan::find()
                ->select('tahun')
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->column();
        } else if ($dataType === 'Hunian') {
            $yearList = DataHunian::find()
                ->select('kodeTahun')
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->column();
        } else if ($dataType === 'Irigasi Saluran') {
            $yearList = IrigasiSaluran::find()
                ->select('kodeTahun')
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->column();
        } else if ($dataType === 'Irigasi Bangunan') {
            $yearList = IrigasiBangunan::find()
                ->select('kodeTahun')
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->column();
        } else if ($dataType === 'Irigasi Terdampak') {
            $yearList = IrigasiTerdampak::find()
                ->select('kodeTahun')
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->column();
        } else if ($dataType === 'KPSPAMS') {
            $yearList = DataKpspams::find()
                ->select('kodeTahun')
                ->distinct()
                ->where(['kodeKecamatan' => $kodeKecamatan])
                ->column();
        }

        return json_encode($yearList);
    }
}
