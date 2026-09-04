<?php

namespace backend\controllers;

use Yii;
use backend\models\DataJembatan;
use backend\models\DataDesa;
use backend\models\DataKecamatan;
use backend\models\search\DataJembatanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UploadDataJembatan;
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
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * DataJembatanController implements the CRUD actions for DataJembatan model.
 */
class DataJembatanController extends Controller
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
     * Lists all DataJembatan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DataJembatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Set sorting by 'tahun' DESC
        $dataProvider->sort->defaultOrder = ['tahun' => SORT_DESC];

        // Disable pagination if you want to show all data
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single DataJembatan model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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
     * Creates a new DataJembatan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DataJembatan();

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
     * Updates an existing DataJembatan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DataJembatan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    // controllers/YourController.php

    public function actionUpload()
    {
        $model = new UploadDataJembatan();

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

                    $jembatan = new DataJembatan();
                    $jembatan->namaPekerjaan = !empty($row[0]) ? $row[0] : null; // Column 0
                    $jembatan->kodeDesa = !empty($row[1]) ? $row[1] : null; // Column 1
                    $jembatan->kodeKecamatan = !empty($row[2]) ? $row[2] : null; // Column 2
                    $jembatan->alamat = !empty($row[3]) ? $row[3] : null; // Column 3
                    $jembatan->penyedia = !empty($row[4]) ? $row[4] : null; // Column 4
                    $jembatan->nilaiPagu = !empty($row[5]) ? (int)$row[5] : null; // Column 5
                    $jembatan->nilaiKontrak = !empty($row[6]) ? (int)$row[6] : null; // Column 6
                    $jembatan->nilaiAddendum = !empty($row[7]) ? (int)$row[7] : null; // Column 7
                    $jembatan->nomorSpmk = !empty($row[8]) ? $row[8] : null; // Column 8
                    $jembatan->nomorKontrak = !empty($row[9]) ? $row[9] : null; // Column 9
                    $jembatan->nomorAddendum = !empty($row[10]) ? $row[10] : null; // Column 10
                    $jembatan->nomorPho = !empty($row[11]) ? $row[11] : null; // Column 11
                    $jembatan->realisasiPanjang = !empty($row[12]) ? (int)$row[12] : null; // Column 12
                    $jembatan->realisasiLebar = !empty($row[13]) ? (int)$row[13] : null; // Column 13
                    $jembatan->keterangan = !empty($row[14]) ? $row[14] : null; // Column 14
                    $jembatan->tahun = !empty($row[15]) ? (int)$row[15] : null; // Column 15

                    if (!$jembatan->save()) {
                        // Handle validation errors or log them
                        Yii::$app->session->setFlash('error', 'Error saving row ' . ($index + 1) . ': ' . implode(', ', $jembatan->getFirstErrors()));
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
     * Finds the DataJembatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DataJembatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataJembatan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
