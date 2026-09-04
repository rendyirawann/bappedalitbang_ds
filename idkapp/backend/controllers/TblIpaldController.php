<?php

namespace backend\controllers;

use Yii;
use backend\models\TblIpald;
use backend\models\search\TblIpaldSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UploadFormIpald;
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
 * TblIpaldController implements the CRUD actions for TblIpald model.
 */
class TblIpaldController extends Controller
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
     * Lists all TblIpald models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblIpaldSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblIpald model.
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
     * Creates a new TblIpald model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblIpald();

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
     * Updates an existing TblIpald model.
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
     * Deletes an existing TblIpald model.
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
    $model = new UploadFormIpald();

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
                    Yii::$app->session->setFlash('error', 'Error saving row ' . ($index + 1) . ': Enumerator, Fasilitas, and Wilayah cannot be blank.');
                    return $this->render('upload', ['model' => $model]);
                }

                $ipald = new TblIpald();
                $ipald->no = $row[0]; // Column 0
                $ipald->enumerator = $row[1]; // Column 1
                $ipald->fasilitas = $row[2]; // Column 2
                $ipald->wilayah = $row[3]; // Column 3
                $ipald->thn_pembangunan = (int) $row[4]; // Column 4
                $ipald->thn_rehabilitasi = (int) $row[5]; // Column 5
                $ipald->kapasitas_desain = (int) $row[6]; // Column 6
                $ipald->kapasitas_pakai = (int) $row[7]; // Column 7
                $ipald->sistem = $row[8]; // Column 8
                $ipald->kondisi = $row[9]; // Column 9
                $ipald->pengelola = $row[10]; // Column 10
                $ipald->pengecekan = $row[11]; // Column 11
                $ipald->nama_lembaga = $row[12]; // Column 12
                $ipald->bentuk_lembaga = $row[13]; // Column 13
                $ipald->jlh_anggota = $row[14]; // Column 14
                $ipald->kel_bidang = $row[15]; // Column 15
                $ipald->operasional = $row[16]; // Column 16
                $ipald->asset = $row[17]; // Column 17
                $ipald->status = $row[18]; // Column 18
                $ipald->latitude = $this->parseDecimal($row[19]); // Column 19
                $ipald->longitude = $this->parseDecimal($row[20]); // Column 20

                // Validate latitude and longitude as numbers
                if (!is_numeric($ipald->latitude) || !is_numeric($ipald->longitude)) {
                    Yii::$app->session->setFlash('error', 'Error saving row ' . ($index + 1) . ': Latitude and Longitude must be numbers.');
                    return $this->render('upload', ['model' => $model]);
                }

                if (!$ipald->save()) {
                    // Handle validation errors or log them
                    Yii::$app->session->setFlash('error', 'Error saving row ' . ($index + 1) . ': ' . implode(', ', $ipald->getFirstErrors()));
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
    $models = TblIpald::find()->all();

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
    $models = TblIpald::find()->all();

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
     * Finds the TblIpald model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TblIpald the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblIpald::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
