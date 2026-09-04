<?php

namespace backend\controllers;

use Yii;
use backend\models\IrigasiSaluran;
use backend\models\search\IrigasiSaluran as IrigasiSaluranSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UploadDataIrigasiSaluran;
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
 * IrigasiSaluranController implements the CRUD actions for IrigasiSaluran model.
 */
class IrigasiSaluranController extends Controller
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
     * Lists all IrigasiSaluran models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new IrigasiSaluranSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IrigasiSaluran model.
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
     * Creates a new IrigasiSaluran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new IrigasiSaluran();

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
     * Updates an existing IrigasiSaluran model.
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

    public function actionUpload()
    {
        $model = new UploadDataIrigasiSaluran();

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

                    $individu = new IrigasiSaluran();
                    $individu->nomeklatur = !empty($row[0]) ? $row[0] : null; // Column 0
                    $individu->kodeDesa = !empty($row[1]) ? $row[1] : null; // Column 1
                    $individu->luasIrigasi = !empty($row[2]) ? (int)$row[2] : null; // Column 2
                    $individu->igt = !empty($row[3]) ? $row[3] : null; // Column 3
                    $individu->primerKondisiBaik = !empty($row[5]) ? $row[5] : null; // Column 5
                    $individu->primerSaluranStatus = !empty($row[4]) ? $row[4] : null; // Column 4
                    $individu->primerPjgSaluran = !empty($row[6]) ? $row[6] : null; // Column 6
                    $individu->primerSaluranBaik = !empty($row[7]) ? $row[7] : null; // Column 7
                    $individu->sekunderKondisiBaik = !empty($row[9]) ? $row[9] : null; // Column 9
                    $individu->sekunderSaluranStatus = !empty($row[8]) ? $row[8] : null; // Column 8
                    $individu->sekunderPjgSaluran = !empty($row[10]) ? $row[10] : null; // Column 10
                    $individu->sekunderSaluranBaik = !empty($row[11]) ? $row[11] : null; // Column 11
                    $individu->pembuangKondisiBaik = !empty($row[12]) ? $row[12] : null; // Column 12
                    $individu->pembuangSaluranStatus = !empty($row[13]) ? $row[13] : null; // Column 13
                    $individu->bangunanBagiKondisiBaik = !empty($row[14]) ? $row[14] : null; // Column 14
                    $individu->bangunanBagiStatus = !empty($row[15]) ? $row[15] : null; // Column 15
                    $individu->bangunanBagiSadapKondisiBaik = !empty($row[16]) ? $row[16] : null; // Column 16
                    $individu->bangunanBagiSadapStatus = !empty($row[17]) ? $row[17] : null; // Column 17
                    $individu->bangunanSadapKondisiBaik = !empty($row[18]) ? $row[18] : null; // Column 18
                    $individu->bangunanSadapStatus = !empty($row[19]) ? $row[19] : null; // Column 19
                    $individu->bangunanPintuAirKondisiBaik = !empty($row[20]) ? $row[20] : null; // Column 20
                    $individu->bangunanPintuAirStatus = !empty($row[21]) ? $row[21] : null; // Column 21
                    $individu->bangunanTalangKondisiBaik = !empty($row[22]) ? $row[22] : null; // Column 22
                    $individu->bangunanTalangStatus = !empty($row[23]) ? $row[23] : null; // Column 23
                    $individu->bangunanSiponKondisiBaik = !empty($row[24]) ? $row[24] : null; // Column 24
                    $individu->bangunanSiponStatus = !empty($row[25]) ? $row[25] : null; // Column 25
                    $individu->bangunanGorongKondisiBaik = !empty($row[26]) ? $row[26] : null; // Column 26
                    $individu->bangunanGorongStatus = !empty($row[27]) ? $row[27] : null; // Column 27
                    $individu->bangunanTerjunKondisiBaik = !empty($row[28]) ? $row[28] : null; // Column 28
                    $individu->bangunanTerjunStatus = !empty($row[29]) ? $row[29] : null; // Column 29
                    $individu->bangunanTanggulKondisiBaik = !empty($row[30]) ? $row[30] : null; // Column 30
                    $individu->bangunanTanggulStatus = !empty($row[31]) ? $row[31] : null; // Column 31
                    $individu->rataJaringanKondisiBaik = !empty($row[32]) ? $row[32] : null; // Column 32
                    $individu->rataJaringanStatus = !empty($row[33]) ? $row[33] : null; // Column 33
                    $individu->arealBaik = !empty($row[34]) ? $row[34] : null; // Column 34
                    $individu->arealRusakRingan = !empty($row[35]) ? $row[35] : null; // Column 35
                    $individu->arealRusakSedang = !empty($row[36]) ? $row[36] : null; // Column 36
                    $individu->arealRusakBerat = !empty($row[37]) ? $row[37] : null; // Column 37
                    $individu->arealTotal = !empty($row[38]) ? $row[38] : null; // Column 38
                    $individu->indeksPrasaranaFisik = !empty($row[39]) ? $row[39] : null; // Column 39
                    $individu->indeksProduktivitas = !empty($row[40]) ? $row[40] : null; // Column 40
                    $individu->indeksSaranaPenunjang = !empty($row[41]) ? $row[41] : null; // Column 41
                    $individu->indeksOrganisasiPersonalia = !empty($row[42]) ? $row[42] : null; // Column 42
                    $individu->indeksDokumentasi = !empty($row[43]) ? $row[43] : null; // Column 43
                    $individu->indeksPpa = !empty($row[44]) ? $row[44] : null; // Column 44
                    $individu->indeksJumlah = !empty($row[45]) ? $row[45] : null; // Column 45
                    $individu->indeksKategori = !empty($row[46]) ? $row[46] : null; // Column 46
                    $individu->keterangan = !empty($row[47]) ? $row[47] : null; // Column 47
                    $individu->kodeTahun = !empty($row[48]) ? (int)$row[48] : null; // Column 48

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
     * Deletes an existing IrigasiSaluran model.
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

    /**
     * Finds the IrigasiSaluran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return IrigasiSaluran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IrigasiSaluran::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
