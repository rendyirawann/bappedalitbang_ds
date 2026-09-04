<?php

namespace backend\controllers;

use Yii;
use backend\models\TblIndividu2021;
use backend\models\search\TblIndividu2021Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UploadFormIndividu2021;
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
 * TblIndividu2021Controller implements the CRUD actions for TblIndividu2021 model.
 */
class TblIndividu2021Controller extends Controller
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
     * Lists all TblIndividu2021 models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblIndividu2021Search();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblIndividu2021 model.
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
     * Creates a new TblIndividu2021 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblIndividu2021();

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
     * Updates an existing TblIndividu2021 model.
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

    // controllers/YourController.php

public function actionUpload()
{
    $model = new UploadFormIndividu2021();

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

                $individu = new TblIndividu2021();
                $individu->no = (int)$row[0]; // Column 0
                $individu->namaKegiatan = !empty($row[1]) ? $row[1] : null; // Column 1
                $individu->desa = !empty($row[2]) ? $row[2] : null; // Column 2
                $individu->keterangan = !empty($row[3]) ? $row[3] : null; // Column 3
                $individu->uraian = !empty($row[4]) ? $row[4] : null; // Column 4
                $individu->target = !empty($row[5]) ? $row[5] : null; // Column 5
                $individu->capaian = !empty($row[6]) ? $row[6] : null; // Column 6

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

public function actionExportCsv()
{
    $models = TblIndividu2021::find()->all();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add header row
    $sheet->fromArray([
        ['ID', 'No', 'Enumerator', 'Fasilitas', 'Wilayah', 'Thn Pembangunan', 'Thn Rehabilitasi', 'Kapasitas Desain', 'Kapasitas Pakai', 'Sistem', 'Kondisi', 'Pengelola', 'Pengecekan', 'Nama Lembaga', 'Bentuk Lembaga', 'Jlh Anggota', 'Kel Bidang', 'Operasional', 'Asset', 'Status', 'Latitude', 'Longitude'],
    ], NULL, 'A1');

    // Add data rows
    $row = 2;
    foreach ($models as $model) {
        $sheet->setCellValue('A' . $row, $model->id);
        $sheet->setCellValue('B' . $row, $model->no);
        $sheet->setCellValue('C' . $row, $model->enumerator);
        $sheet->setCellValue('D' . $row, $model->fasilitas);
        $sheet->setCellValue('E' . $row, $model->wilayah);
        $sheet->setCellValue('F' . $row, $model->thn_pembangunan);
        $sheet->setCellValue('G' . $row, $model->thn_rehabilitasi);
        $sheet->setCellValue('H' . $row, $model->kapasitas_desain);
        $sheet->setCellValue('I' . $row, $model->kapasitas_pakai);
        $sheet->setCellValue('J' . $row, $model->sistem);
        $sheet->setCellValue('K' . $row, $model->kondisi);
        $sheet->setCellValue('L' . $row, $model->pengelola);
        $sheet->setCellValue('M' . $row, $model->pengecekan);
        $sheet->setCellValue('N' . $row, $model->nama_lembaga);
        $sheet->setCellValue('O' . $row, $model->bentuk_lembaga);
        $sheet->setCellValue('P' . $row, $model->jlh_anggota);
        $sheet->setCellValue('Q' . $row, $model->kel_bidang);
        $sheet->setCellValue('R' . $row, $model->operasional);
        $sheet->setCellValue('S' . $row, $model->asset);
        $sheet->setCellValue('T' . $row, $model->status);
        $sheet->setCellValue('U' . $row, $model->latitude);
        $sheet->setCellValue('V' . $row, $model->longitude);
        
        $row++;
    }

    // Save to CSV file
    $writer = new CsvWriter($spreadsheet);
    $filename = 'tbl_ipald_export_' . date('YmdHis') . '.csv';
    $writer->save($filename);

    // Download the file
    Yii::$app->response->sendFile($filename);
}


public function actionExportXlsx()
{
    $models = TblIndividu2021::find()->all();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add header row
    $sheet->fromArray([
        ['ID', 'No', 'Enumerator', 'Fasilitas', 'Wilayah', 'Thn Pembangunan', 'Thn Rehabilitasi', 'Kapasitas Desain', 'Kapasitas Pakai', 'Sistem', 'Kondisi', 'Pengelola', 'Pengecekan', 'Nama Lembaga', 'Bentuk Lembaga', 'Jlh Anggota', 'Kel Bidang', 'Operasional', 'Asset', 'Status', 'Latitude', 'Longitude'],
    ], NULL, 'A1');

    // Add data rows
    $row = 2;
    foreach ($models as $model) {
        $sheet->setCellValue('A' . $row, $model->id);
        $sheet->setCellValue('B' . $row, $model->no);
        $sheet->setCellValue('C' . $row, $model->enumerator);
        $sheet->setCellValue('D' . $row, $model->fasilitas);
        $sheet->setCellValue('E' . $row, $model->wilayah);
        $sheet->setCellValue('F' . $row, $model->thn_pembangunan);
        $sheet->setCellValue('G' . $row, $model->thn_rehabilitasi);
        $sheet->setCellValue('H' . $row, $model->kapasitas_desain);
        $sheet->setCellValue('I' . $row, $model->kapasitas_pakai);
        $sheet->setCellValue('J' . $row, $model->sistem);
        $sheet->setCellValue('K' . $row, $model->kondisi);
        $sheet->setCellValue('L' . $row, $model->pengelola);
        $sheet->setCellValue('M' . $row, $model->pengecekan);
        $sheet->setCellValue('N' . $row, $model->nama_lembaga);
        $sheet->setCellValue('O' . $row, $model->bentuk_lembaga);
        $sheet->setCellValue('P' . $row, $model->jlh_anggota);
        $sheet->setCellValue('Q' . $row, $model->kel_bidang);
        $sheet->setCellValue('R' . $row, $model->operasional);
        $sheet->setCellValue('S' . $row, $model->asset);
        $sheet->setCellValue('T' . $row, $model->status);
        $sheet->setCellValue('U' . $row, $model->latitude);
        $sheet->setCellValue('V' . $row, $model->longitude);
        
        $row++;
    }

    // Save to XLSX file
    $writer = new Xlsx($spreadsheet);
    $filename = 'tbl_ipald_export_' . date('YmdHis') . '.xlsx';
    $writer->save($filename);

    // Download the file
    Yii::$app->response->sendFile($filename);
}

    /**
     * Deletes an existing TblIndividu2021 model.
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
     * Finds the TblIndividu2021 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TblIndividu2021 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblIndividu2021::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
