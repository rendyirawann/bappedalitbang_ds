<?php

namespace backend\controllers;

use Yii;
use backend\models\IrigasiTerdampak;
use backend\models\search\IrigasiTerdampakSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UploadDataIrigasiTerdampak;
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

/**
 * IrigasiTerdampakController implements the CRUD actions for IrigasiTerdampak model.
 */
class IrigasiTerdampakController extends Controller
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
     * Lists all IrigasiTerdampak models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new IrigasiTerdampakSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IrigasiTerdampak model.
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
     * Creates a new IrigasiTerdampak model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new IrigasiTerdampak();

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

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing IrigasiTerdampak model.
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
     * Deletes an existing IrigasiTerdampak model.
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
        $model = new UploadDataIrigasiTerdampak();

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

                    $terdampak = new IrigasiTerdampak();
                    $terdampak->nomeklatur = !empty($row[0]) ? $row[0] : null; // Column 0
                    $terdampak->kodeDesa = !empty($row[1]) ? $row[1] : null; // Column 1
                    $terdampak->luasIrigasi = !empty($row[2]) ? $row[2] : null; // Column 2
                    $terdampak->arealBaik = !empty($row[3]) ? $row[3] : null; // Column 3
                    $terdampak->arealRusakRingan = !empty($row[4]) ? $row[4] : null; // Column 4
                    $terdampak->arealRusakSedang = !empty($row[5]) ? $row[5] : null; // Column 5
                    $terdampak->arealRusakBerat = !empty($row[6]) ? $row[6] : null; // Column 6
                    $terdampak->total = !empty($row[7]) ? $row[7] : null; // Column 7
                    $terdampak->kodeTahun = !empty($row[8]) ? (int)$row[8] : null; // Column 8

                    if (!$terdampak->save()) {
                        // Handle validation errors or log them
                        Yii::$app->session->setFlash('error', 'Error saving row ' . ($index + 1) . ': ' . implode(', ', $terdampak->getFirstErrors()));
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
     * Finds the IrigasiTerdampak model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return IrigasiTerdampak the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IrigasiTerdampak::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
