<?php

namespace frontend\controllers;

use Yii;
use frontend\models\StandarPelayanan;
use frontend\models\search\StandarPelayananSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * StandarPelayananController menampilkan dokumen Standar Pelayanan di frontend.
 */
class StandarPelayananController extends Controller
{
    /**
     * Lists all StandarPelayanan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StandarPelayananSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        // Menonaktifkan paginasi
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Mengunduh file dokumen Standar Pelayanan.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the file cannot be found
     */
    public function actionDownload($id)
    {
        $model = $this->findModel($id);

        $filePath = Yii::getAlias('@frontend/web/uploads/standar-pelayanan/') . $model->file;

        if (file_exists($filePath)) {
            $extension = pathinfo($model->file, PATHINFO_EXTENSION);
            $downloadName = str_replace(['/', '\\'], '-', $model->namaFile) . '.' . $extension;

            return Yii::$app->response->sendFile($filePath, $downloadName);
        }

        throw new NotFoundHttpException('The requested file does not exist.');
    }

    /**
     * Finds the StandarPelayanan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return StandarPelayanan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StandarPelayanan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
