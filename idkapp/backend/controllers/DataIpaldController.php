<?php

namespace backend\controllers;

use Yii;
use backend\models\DataIpald;
use backend\models\DataDesa;
use backend\models\DataKecamatan;
use backend\models\search\DataIpaldSearch;
use backend\models\DataSampah;
use backend\models\search\DataSampahSearch;
use backend\models\SampahDokumen;
use backend\models\search\SampahDokumenSearch;
use backend\models\IpaldDokumen;
use backend\models\search\IpaldDokumenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UploadDataIpald;
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\Reader\Csv as CsvReader;
use PhpOffice\PhpSpreadsheet\Writer\Csv as CsvWriter;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use yii\helpers\Url;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\Expression;
use backend\assets\LeafletAsset; // Tambahkan ini
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * DataIpaldController implements the CRUD actions for DataIpald model.
 */
class DataIpaldController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all DataIpald models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DataIpaldSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DataIpald model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        LeafletAsset::register($this->view); // Registrasi LeafletAsset

        $model = $this->findModel($id);

        // Ambil data gambar terkait dengan kodeDataIpald saat ini
        $ipaldDokumens = \backend\models\IpaldDokumen::find()
            ->where(['kodeDataIpald' => $model->id])
            ->all();

        return $this->render('view', [
            'model' => $model,
            'ipaldDokumens' => $ipaldDokumens, // Pass the images data to the view
        ]);
    }

    public function actionMarker()
    {
        LeafletAsset::register($this->view); // Registrasi LeafletAsset

        $dataIpald = DataIpald::find()->all();
        $ipaldDokumens = IpaldDokumen::find()->all();

        return $this->render('marker', [
            'dataIpald' => $dataIpald,
            'ipaldDokumens' => $ipaldDokumens, // Pass the images data to the view
        ]);
    }

    public function actionMarkerAll()
    {
        LeafletAsset::register($this->view); // Registrasi LeafletAsset

        // Ambil semua data dari DataSampah dan DataIpald
        $modelsSampah = DataSampah::find()->all();
        $modelsIpald = DataIpald::find()->all();

        // Ambil semua dokumen terkait
        $sampahDokumens = SampahDokumen::find()->all();
        $ipaldDokumens = IpaldDokumen::find()->all();

        // Inisialisasi data untuk JavaScript
        $markers = [];
        $dokumenMap = []; // Array untuk menyimpan dokumen berdasarkan id

        // Kumpulkan data markers dan dokumen terkait
        foreach ($modelsSampah as $model) {
            $markers[] = [
                'latitude' => $model->latitude,
                'longitude' => $model->longitude,
                'fasilitas' => $model->fasilitas,
                'alamat' => $model->alamat,
                'id' => $model->id,
                'jenis_data' => 'data_sampah', // Menandakan jenis data
            ];

            foreach ($sampahDokumens as $dokumen) {
                if ($dokumen->kodeDataSampah == $model->id) {
                    $dokumenMap[$model->id][] = [
                        'file' => $dokumen->file
                    ];
                }
            }
        }

        foreach ($modelsIpald as $model) {
            $markers[] = [
                'latitude' => $model->latitude,
                'longitude' => $model->longitude,
                'fasilitas' => $model->fasilitas,
                'alamat' => $model->alamat,
                'id' => $model->id,
                'jenis_data' => 'data_ipald', // Menandakan jenis data
            ];

            foreach ($ipaldDokumens as $dokumen) {
                if ($dokumen->kodeDataIpald == $model->id) {
                    $dokumenMap[$model->id][] = [
                        'file' => $dokumen->file
                    ];
                }
            }
        }

        $markers = Json::encode($markers);
        $dokumenMap = Json::encode($dokumenMap);

        return $this->render('marker-all', [
            'markers' => $markers,
            'dokumenMap' => $dokumenMap // Pass the images data to the view
        ]);
    }


    public function actionGetDesa($kodeKecamatan)
{
    $dataDesa = DataDesa::find()
        ->where(['idKecamatan' => $kodeKecamatan])
        ->all();

    $listData = ArrayHelper::map($dataDesa, 'kode', 'namaDesa');
    return $this->asJson($listData);
}


    /**
     * Creates a new DataIpald model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DataIpald();

        if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Berhasil Tambah Data');
                    return $this->asJson(['success' => true, 'redirect' => \yii\helpers\Url::to(['view', 'id' => $model->id])]);
                } else {
                    // Tambahkan log error
                    Yii::error("Error saving data: " . json_encode($model->getErrors()));
                    return $this->asJson(['success' => false, 'errors' => $model->getErrors()]);
                }
            }

            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }

        // if ($model->load(Yii::$app->request->post())) {
        //     if ($model->save()) {
        //         Yii::$app->session->setFlash('success', 'Berhasil Tambah Data');
        //         return $this->redirect(['view', 'id' => $model->id]);
        //     } else {
        //         // Tambahkan log error
        //         Yii::error("Error saving data: " . json_encode($model->getErrors()));
        //     }
        // }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DataIpald model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Berhasil Update Data');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DataIpald model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Berhasil Hapus Data');
        return $this->redirect(['index']);
    }

    // controllers/YourController.php

    // controllers/YourController.php

    public function actionUpload()
    {
        $model = new UploadDataIpald();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $filePath = $model->upload();
            if ($filePath) {
                // Load CSV file using PhpSpreadsheet CSV reader
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                $reader->setDelimiter(';'); // Set the delimiter to semicolon
                $spreadsheet = $reader->load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                // Iterate through the rows, skipping the header if necessary
                foreach ($rows as $index => $row) {
                    if ($index === 0) {
                        // Skip the header row if present
                        continue;
                    }

                    // Trim each row's data to remove unwanted spaces
                    $row = array_map('trim', $row);

                    $individu = new DataIpald();
                    $individu->enumerator = !empty($row[0]) ? $row[0] : null; // Column 0
                    $individu->fasilitas = !empty($row[1]) ? $row[1] : null; // Column 1
                    $individu->kodeDesa = !empty($row[2]) ? $row[2] : null; // Column 2
                    $individu->kodeKecamatan = !empty($row[3]) ? $row[3] : null; // Column 3
                    $individu->alamat = !empty($row[4]) ? $row[4] : null; // Column 4
                    $individu->tahunPembangunan = !empty($row[5]) ? (int)$row[5] : null; // Column 5
                    $individu->tahunRehabilitasi = !empty($row[6]) ? (int)$row[6] : null; // Column 6
                    $individu->kapasitasDesain = !empty($row[7]) ? (int)$row[7] : null; // Column 7
                    $individu->kapasitasPakai = !empty($row[8]) ? (int)$row[8] : null; // Column 8
                    $individu->sistem = !empty($row[9]) ? $row[9] : null; // Column 9
                    $individu->kondisi = !empty($row[10]) ? $row[10] : null; // Column 10
                    $individu->kodePengelola = !empty($row[11]) ? $row[11] : null; // Column 11
                    $individu->cekEffluent = !empty($row[12]) ? $row[12] : null; // Column 12
                    $individu->namaLembaga = !empty($row[13]) ? $row[13] : null; // Column 13
                    $individu->bentukLembaga = !empty($row[14]) ? $row[14] : null; // Column 14
                    $individu->jumlahAnggota = !empty($row[15]) ? (int)$row[15] : null; // Column 15
                    $individu->kodeBidang = !empty($row[16]) ? $row[16] : null; // Column 16
                    $individu->kodeDana = !empty($row[17]) ? $row[17] : null; // Column 17
                    $individu->kodeAset = !empty($row[18]) ? $row[18] : null; // Column 18
                    $individu->kodeStatus = !empty($row[19]) ? $row[19] : null; // Column 19
                    $individu->latitude = !empty($row[20]) ? $this->parseDecimal($row[20]) : null; // Column 20
                    $individu->longitude = !empty($row[21]) ? $this->parseDecimal($row[21]) : null; // Column 21

                    if (!$individu->save()) {
                        // Handle validation errors or log them
                        Yii::$app->session->setFlash('error', 'Error saving row ' . ($index + 1) . ': ' . implode(', ', $individu->getFirstErrors()));
                        return $this->render('upload', ['model' => $model]);
                    }
                }

                Yii::$app->session->setFlash('success', 'CSV file has been successfully uploaded and data saved to database.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('upload', [
            'model' => $model,
        ]);
    }

    private function parseDecimal($value)
    {
        // Replace commas with periods for decimal values
        return str_replace(',', '.', $value);
    }


    /**
     * Finds the DataIpald model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DataIpald the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataIpald::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
