<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use backend\models\DataSampah;
use backend\models\DataIpald;
use backend\models\DataIndividu;
use backend\models\DataJembatan;
use backend\models\DataHunian;
use backend\models\DataKpspams;
use backend\models\IrigasiSaluran;
use backend\models\IrigasiBangunan;
use backend\models\IrigasiTerdampak;
use backend\models\SampahDokumen;
use backend\models\IpaldDokumen;
use backend\models\User;
use backend\models\Refsasaranrenstra;
use backend\models\Cascadingrenstrasasaran;
use backend\models\TargetIndikatorSasaran;
use dosamigos\leaflet\LeafletAsset;
use backend\models\SakipSkpd;
use backend\models\SakipPeriode;
use backend\models\SakipSasaran;
use backend\models\SakipKoordinasi;
use backend\models\SakipIndikatorsasaranrenstra;
use backend\models\search\SakipIndikatorsasaranrenstraSearch;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($refperiode_id = null, $refskpd_id = null)
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

        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->id);
        $searchModel = new SakipIndikatorsasaranrenstraSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = false;

        // =========================================================================
        // BLOK LOGIKA BARU UNTUK KEAMANAN SKPD
        // =========================================================================

        $user = Yii::$app->user->identity;
        // $assignments = Yii::$app->authManager->getAssignments($user->id);

        $skpdList = [];
        $allowedSkpdIds = []; // Daftar ID SKPD yang diizinkan untuk user ini

        if (isset($assignments['superadmin']) || isset($assignments['admin'])) {
            // --- BLOK UNTUK ADMIN ---
            $allSkpd = SakipSkpd::find()->where(['skpd_isaktif' => 'T'])->orderBy('nama_skpd ASC')->all();
            $skpdList = ArrayHelper::map($allSkpd, 'refskpd_id', 'nama_skpd');
            $allowedSkpdIds = array_keys($skpdList);
        } elseif ($user->id == 6) {
            // --- BLOK KHUSUS UNTUK USER ID 6 (KOORDINATOR BIDANG) ---
            $coordinatedSkpdIds = SakipKoordinasi::find()
                ->select('refskpd_id')
                ->where(['refuser_id' => $user->id])
                ->column();

            $allowedSkpdIds = $coordinatedSkpdIds;

            if (!empty($allowedSkpdIds)) {
                $skpdList = ArrayHelper::map(
                    SakipSkpd::find()->where(['refskpd_id' => $allowedSkpdIds, 'skpd_isaktif' => 'T'])->orderBy('nama_skpd ASC')->all(),
                    'refskpd_id',
                    'nama_skpd'
                );
            }
        } else {
            // --- BLOK UNTUK USER SKPD BIASA (OPD) ---
            // Hanya bisa melihat SKPD miliknya sendiri berdasarkan instansi_id

            // --- PERUBAHAN DI SINI ---
            $userSkpdId = $user->instansi_id; // Menggunakan instansi_id dari model User

            $allowedSkpdIds = [$userSkpdId]; // Hanya satu SKPD yang diizinkan
            if (!empty($userSkpdId)) {
                $skpdList = ArrayHelper::map(
                    SakipSkpd::find()->where(['refskpd_id' => $userSkpdId, 'skpd_isaktif' => 'T'])->all(),
                    'refskpd_id',
                    'nama_skpd'
                );
            }
        }

        // --- Validasi Keamanan (tidak perlu diubah) ---
        if ($refskpd_id !== null && !empty($allowedSkpdIds) && !in_array($refskpd_id, $allowedSkpdIds)) {
            throw new ForbiddenHttpException('Anda tidak memiliki hak akses untuk melihat data SKPD ini.');
        }

        if ($refskpd_id === null || (!empty($allowedSkpdIds) && !in_array($refskpd_id, $allowedSkpdIds))) {
            $refskpd_id = !empty($allowedSkpdIds) ? $allowedSkpdIds[0] : null;
        }

        // =========================================================================
        // AKHIR DARI BLOK LOGIKA BARU
        // Kode di bawah ini sekarang menggunakan $refskpd_id yang sudah aman
        // =========================================================================

        // Ambil nama_skpd berdasarkan refskpd_id
        $nama_skpd = $refskpd_id ? SakipSkpd::find()->select('nama_skpd')->where(['refskpd_id' => $refskpd_id])->scalar() : 'Tidak ada SKPD dipilih';

        // Ambil semua periode
        $periodeList = SakipPeriode::find()->all();

        // Set default period to this year if not provided
        if ($refperiode_id === null) {
            $currentYear = date('Y');
            $defaultPeriod = SakipPeriode::find()->where(['periode' => $currentYear])->one();
            $refperiode_id = $defaultPeriod ? $defaultPeriod->refperiode_id : null;
        }

        // Logika query utama Anda tidak diubah
        $query = SakipIndikatorsasaranrenstra::find()->where(['refskpd_id' => $refskpd_id]);

        if ($refperiode_id !== null) {
            $query->andWhere(['refperiode_id' => $refperiode_id]);
        }

        // Execute query and get data
        $data = $query->all();

        // Add a flag to check if data is empty
        $dataEmpty = empty($data);

        // Retrieve the periode based on refperiode_id
        $selectedPeriod = SakipPeriode::find()->where(['refperiode_id' => $refperiode_id])->one();
        $selectedPeriodValue = $selectedPeriod ? $selectedPeriod->periode : null; // Get the periode value


        return $this->render('index', [
            'totalDataBankSampah' => $totalDataBankSampah,
            'totalDataIpald' => $totalDataIpald,
            'totalDataIndividu' => $totalDataIndividu,
            'totalDataJembatan' => $totalDataJembatan,
            'totalDataHunian' => $totalDataHunian,
            'totalDataIrigasi' => $totalDataIrigasi,
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
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'nama_skpd' => $nama_skpd,
            'periodeList' => $periodeList,  // Kirim data periode ke view
            'selectedPeriodId' => $refperiode_id, // Add selected period id
            'dataEmpty' => $dataEmpty, // Pass the data empty flag
            'data' => $data, // Send the queried data
            'selectedPeriodValue' => $selectedPeriodValue, // Include selected period value
            'selectedSkpdId' => $refskpd_id,
            'skpdList' => $skpdList,
        ]);
    }


    public function actionMarkerAll()
    {

        $dataSampah = DataSampah::find()->all();
        $sampahDokumens = SampahDokumen::find()->all();
        $dataIpald = DataIpald::find()->all();
        $ipaldDokumens = IpaldDokumen::find()->all();

        return $this->render('marker-all', [
            'dataSampah' => $dataSampah,
            'sampahDokumens' => $sampahDokumens,
            'dataIpald' => $dataIpald,
            'ipaldDokumens' => $ipaldDokumens,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
