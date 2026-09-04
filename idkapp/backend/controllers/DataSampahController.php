<?php

namespace backend\controllers;

use Yii;
use backend\models\DataSampah;
use backend\models\DataDesa;
use backend\models\DataKecamatan;
use backend\models\search\DataSampahSearch;
use backend\models\SampahDokumen;
use backend\models\search\SampahDokumenSearch;
use backend\models\DataIpald;
use backend\models\IpaldDokumen;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UploadDataSampah;
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
 * DataSampahController implements the CRUD actions for DataSampah model.
 */
class DataSampahController extends Controller
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
     * Lists all DataSampah models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DataSampahSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DataSampah model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        LeafletAsset::register($this->view); // Registrasi LeafletAsset

        $model = $this->findModel($id);

        // Ambil data gambar terkait dengan kodeDataIpald saat ini
        $sampahDokumens = \backend\models\SampahDokumen::find()
            ->where(['kodeDataSampah' => $model->id])
            ->all();

        return $this->render('view', [
            'model' => $model,
            'sampahDokumens' => $sampahDokumens, // Pass the images data to the view
        ]);
    }

    // DataSampahController.php

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


    public function actionMarker()
    {
        LeafletAsset::register($this->view); // Registrasi LeafletAsset

        // Ambil semua data_sampah
        $models = DataSampah::find()->all();
        $sampahDokumens = SampahDokumen::find()->all();

        // Inisialisasi data untuk JavaScript
        $markers = [];
        $dokumenMap = []; // Array untuk menyimpan dokumen berdasarkan id

        foreach ($models as $model) {
            $markers[] = [
                'latitude' => $model->latitude,
                'longitude' => $model->longitude,
                'fasilitas' => $model->fasilitas,
                'alamat' => $model->alamat,
                'id' => $model->id,
            ];

            // Mengumpulkan dokumen yang sesuai untuk setiap data_sampah
            foreach ($sampahDokumens as $dokumen) {
                if ($dokumen->kodeDataSampah == $model->id) {
                    $dokumenMap[$model->id][] = [
                        'file' => $dokumen->file
                    ];
                }
            }
        }

        $markers = Json::encode($markers);
        $dokumenMap = Json::encode($dokumenMap);

        return $this->render('marker', [
            'markers' => $markers,
            'dokumenMap' => $dokumenMap // Pass the images data to the view
        ]);
    }




    // Controller action to display markers from data_sampah
    // public function actionMarker()
    // {
    //     LeafletAsset::register($this->view); // Registrasi LeafletAsset

    //     $dataSampah = DataSampah::find()->all();
    //     $sampahDokumens = SampahDokumen::find()->all();

    //     return $this->render('marker', [
    //         'dataSampah' => $dataSampah,
    //         'sampahDokumens' => $sampahDokumens, // Pass the images data to the view
    //     ]);
    // }


    // public function actionMarkerAll()
    // {
    //     LeafletAsset::register($this->view); // Register LeafletAsset

    //     $dataSampah = DataSampah::find()->all();
    //     $sampahDokumens = SampahDokumen::find()->all();
    //     $dataIpald = DataIpald::find()->all();
    //     $ipaldDokumens = IpaldDokumen::find()->all();

    //     return $this->render('marker-all', [
    //         'dataSampah' => $dataSampah,
    //         'sampahDokumens' => $sampahDokumens,
    //         'dataIpald' => $dataIpald,
    //         'ipaldDokumens' => $ipaldDokumens,
    //     ]);
    // }


    public function actionGetDesa($kodeKecamatan)
{
    $dataDesa = DataDesa::find()
        ->where(['idKecamatan' => $kodeKecamatan])
        ->all();

    $listData = ArrayHelper::map($dataDesa, 'kode', 'namaDesa');
    return $this->asJson($listData);
}

    /**
     * Creates a new DataSampah model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DataSampah();

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
     * Updates an existing DataSampah model.
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
     * Deletes an existing DataSampah model.
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

    public function actionUpload()
    {
        $model = new UploadDataSampah();

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

                    // Check if a record with the same unique fields already exists
                    $existingRecord = DataSampah::findOne([
                        'kodeDesa' => $row[2],
                        'kodeKecamatan' => $row[3],
                        'kodePengelola' => $row[12],
                        'kodeBidang' => $row[16],
                        'kodeDana' => $row[19],
                        'kodeAset' => $row[20],
                    ]);

                    if ($existingRecord) {
                        // Update the existing record
                        $individu = $existingRecord;
                    } else {
                        // Create a new record
                        $individu = new DataSampah();
                    }

                    $individu->enumerator = !empty($row[0]) ? $row[0] : null; // Column 0
                    $individu->fasilitas = !empty($row[1]) ? $row[1] : null; // Column 1
                    $individu->kodeDesa = !empty($row[2]) ? $row[2] : null; // Column 2
                    $individu->kodeKecamatan = !empty($row[3]) ? $row[3] : null; // Column 3
                    $individu->alamat = !empty($row[4]) ? $row[4] : null; // Column 4
                    $individu->kondisi = !empty($row[5]) ? $row[5] : null; // Column 5
                    $individu->tahunPembangunan = !empty($row[6]) ? (int)$row[6] : null; // Column 6
                    $individu->tahunOptimalisasi = !empty($row[7]) ? (int)$row[7] : null; // Column 7
                    $individu->kegiatanPengurangan = !empty($row[8]) ? $row[8] : null; // Column 8
                    $individu->jlhSampahMasuk = !empty($row[9]) ? $this->parseDecimal($row[9]) : null; // Column 9
                    $individu->jlhSampahKompos = !empty($row[10]) ? $this->parseDecimal($row[10]) : null; // Column 10
                    $individu->jlhSampahResidu = !empty($row[11]) ? $this->parseDecimal($row[11]) : null; // Column 11
                    $individu->kodePengelola = !empty($row[12]) ? $row[12] : null; // Column 12
                    $individu->namaLembaga = !empty($row[13]) ? $row[13] : null; // Column 13
                    $individu->bentukLembaga = !empty($row[14]) ? $row[14] : null; // Column 14
                    $individu->jlhAnggota = !empty($row[15]) ? (int)$row[15] : null; // Column 15
                    $individu->kodeBidang = !empty($row[16]) ? $row[16] : null; // Column 16
                    $individu->wilayah = !empty($row[17]) ? $row[17] : null; // Column 17
                    $individu->kodeDana = !empty($row[18]) ? $row[18] : null; // Column 18
                    $individu->kodeAset = !empty($row[19]) ? $row[19] : null; // Column 19
                    $individu->status = !empty($row[20]) ? $row[20] : null; // Column 20
                    $individu->latitude = !empty($row[21]) ? $this->parseDecimal($row[21]) : null; // Column 21
                    $individu->longitude = !empty($row[22]) ? $this->parseDecimal($row[22]) : null; // Column 22

                    if (!$individu->save(false)) {
                        // Handle errors or log them
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
     * Finds the DataSampah model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DataSampah the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataSampah::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
