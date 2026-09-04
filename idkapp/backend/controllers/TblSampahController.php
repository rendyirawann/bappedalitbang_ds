<?php

namespace backend\controllers;

use Yii;
use backend\models\TblSampah;
use backend\models\search\TblSampahSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UploadFormSampah;
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

/**
 * TblSampahController implements the CRUD actions for TblSampah model.
 */
class TblSampahController extends Controller
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
     * Lists all TblSampah models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblSampahSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblSampah model.
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

    /**
     * Creates a new TblSampah model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblSampah();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblSampah model.
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
     * Deletes an existing TblSampah model.
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

    public function actionUpload()
{
    $model = new UploadFormSampah();

    if (Yii::$app->request->isPost) {
        $model->file = UploadedFile::getInstance($model, 'file');
        $filePath = $model->upload();
        if ($filePath) {
            // Load CSV file using PhpSpreadsheet CSV reader
            $reader = new CsvReader();
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

                // Check if any required fields are empty
                if (empty($row[1]) || empty($row[2]) || empty($row[3])) {
                    Yii::$app->session->setFlash('error', 'Error saving row ' . ($index + 1) . ': Enumerator, Fasilitas, and Lokasi cannot be blank.');
                    return $this->render('upload', ['model' => $model]);
                }

                $sampah = new TblSampah();
                $sampah->no = (int) $row[0]; // Column 0
                $sampah->enumerator = $row[1]; // Column 1
                $sampah->fasilitas = $row[2]; // Column 2
                $sampah->lokasi = $row[3]; // Column 3
                $sampah->kondisi = $row[4]; // Column 4
                $sampah->thn_pembangunan = (int) $row[5]; // Column 5
                $sampah->thn_optimalisasi = (int) $row[6]; // Column 6
                $sampah->kegiatan_pengurangan = $row[7]; // Column 7
                $sampah->jlh_sampah_masuk = $row[8]; // Column 8
                $sampah->jlh_sampah_terolah = $row[9]; // Column 9
                $sampah->jlh_sampah_residu = $row[10]; // Column 10
                $sampah->pengelola = $row[11]; // Column 11
                $sampah->nama_lembaga = $row[12]; // Column 12
                $sampah->bentuk_lembaga = $row[13]; // Column 13
                $sampah->jlh_anggota = $row[14]; // Column 14
                $sampah->kel_bidang = $row[15]; // Column 15
                $sampah->wilayah = $row[16]; // Column 16
                $sampah->operasional = $row[17]; // Column 17
                $sampah->asset = $row[18]; // Column 18
                $sampah->status = $row[19]; // Column 19
                $sampah->latitude = $this->parseDecimal($row[20]); // Column 20
                $sampah->longitude = $this->parseDecimal($row[21]); // Column 21

                // Validate latitude and longitude as numbers
                if (!is_numeric($sampah->latitude) || !is_numeric($sampah->longitude)) {
                    Yii::$app->session->setFlash('error', 'Error saving row ' . ($index + 1) . ': Latitude and Longitude must be numbers.');
                    return $this->render('upload', ['model' => $model]);
                }

                if (!$sampah->save()) {
                    // Handle validation errors or log them
                    Yii::$app->session->setFlash('error', 'Error saving row ' . ($index + 1) . ': ' . implode(', ', $sampah->getFirstErrors()));
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
     * Finds the TblSampah model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TblSampah the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblSampah::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
