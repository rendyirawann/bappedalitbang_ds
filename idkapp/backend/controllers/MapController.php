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

class MapController extends Controller
{

    public function actionIndex()
    {
        $this->layout = 'map-main';
        LeafletAsset::register($this->view);

        // Contoh data koordinat (sebaiknya diambil dari database)
        $dataKoordinat = [
            ['lat' => -6.1751, 'lng' => 106.8650, 'info' => 'Jakarta'],
            ['lat' => -6.2088, 'lng' => 106.8456, 'info' => 'Monas']
        ];

        return $this->render('index', ['dataKoordinat' => $dataKoordinat]);
    }

    public function actionMarker()
    {
        $this->layout = 'map-main';
        LeafletAsset::register($this->view);

        // Contoh data koordinat (sebaiknya diambil dari database)
        $dataKoordinat = [
            ['lat' => -6.1751, 'lng' => 106.8650, 'info' => 'Jakarta'],
            ['lat' => -6.2088, 'lng' => 106.8456, 'info' => 'Monas']
        ];

        return $this->render('marker', ['dataKoordinat' => $dataKoordinat]);
    }

    public function actionPolyline()
    {
        $this->layout = 'map-main';
        LeafletAsset::register($this->view);

        // Contoh data koordinat (sebaiknya diambil dari database)
        $dataKoordinat = [
            ['lat' => -6.1751, 'lng' => 106.8650, 'info' => 'Jakarta'],
            ['lat' => -6.2088, 'lng' => 106.8456, 'info' => 'Monas']
        ];

        return $this->render('polyline', ['dataKoordinat' => $dataKoordinat]);
    }

    public function actionRoute()
    {
        $this->layout = 'map-main';
        LeafletAsset::register($this->view);

        // Contoh data koordinat (sebaiknya diambil dari database)
        $dataKoordinat = [
            ['lat' => -6.1751, 'lng' => 106.8650, 'info' => 'Jakarta'],
            ['lat' => -6.2088, 'lng' => 106.8456, 'info' => 'Monas']
        ];

        return $this->render('route', ['dataKoordinat' => $dataKoordinat]);
    }

    public function actionCircle()
    {
        $this->layout = 'map-main';
        LeafletAsset::register($this->view);

        // Contoh data koordinat (sebaiknya diambil dari database)
        $dataKoordinat = [
            ['lat' => -6.1751, 'lng' => 106.8650, 'info' => 'Jakarta'],
            ['lat' => -6.2088, 'lng' => 106.8456, 'info' => 'Monas']
        ];

        return $this->render('circle', ['dataKoordinat' => $dataKoordinat]);
    }

    public function actionDraw()
    {
        $this->layout = 'map-main';
        LeafletAsset::register($this->view);

        // Contoh data koordinat (sebaiknya diambil dari database)
        $dataKoordinat = [
            ['lat' => -6.1751, 'lng' => 106.8650, 'info' => 'Jakarta'],
            ['lat' => -6.2088, 'lng' => 106.8456, 'info' => 'Monas']
        ];

        return $this->render('draw', ['dataKoordinat' => $dataKoordinat]);
    }

    public function actionMap()
    {
        LeafletAsset::register($this->view);

        // Contoh data koordinat (sebaiknya diambil dari database)
        $dataKoordinat = [
            ['lat' => -6.1751, 'lng' => 106.8650, 'info' => 'Jakarta'],
            ['lat' => -6.2088, 'lng' => 106.8456, 'info' => 'Monas']
        ];

        return $this->render('map', ['dataKoordinat' => $dataKoordinat]);
    }
}


?>