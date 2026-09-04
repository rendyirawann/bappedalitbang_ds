<?php

namespace backend\controllers;

use Yii;
use backend\models\TargetIndikatorSasaran;
use backend\models\search\TargetIndikatorSasaranSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TargetIndikatorSasaranController implements the CRUD actions for TargetIndikatorSasaran model.
 */
class TargetIndikatorSasaranController extends Controller
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
     * Lists all TargetIndikatorSasaran models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TargetIndikatorSasaranSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TargetIndikatorSasaran model.
     * @param int $indikator_id Indikator ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($indikator_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($indikator_id),
        ]);
    }

    /**
     * Creates a new TargetIndikatorSasaran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TargetIndikatorSasaran();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'indikator_id' => $model->indikator_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TargetIndikatorSasaran model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $indikator_id Indikator ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($indikator_id, $tahun_id)
    {
        $model = $this->findModel($indikator_id, $tahun_id);
    
        if ($model === null) {
            // Jika model tidak ditemukan, redirect ke site/index dan tampilkan pesan error
            Yii::$app->session->setFlash('error', 'Tahun yang dipilih tidak memiliki indikator tersebut');
            return $this->redirect(['site/index']);
        }
    
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Berhasil Update Data');
            return $this->redirect(['site/index']);
        }
    
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    protected function findModel($indikator_id, $tahun_id)
    {
        // Jika tahun_id > 1, tambahkan 1 ke indikator_id untuk setiap kenaikan tahun_id.
        if ($tahun_id > 1) {
            $indikator_id += ($tahun_id - 1);
        }
    
        if (($model = TargetIndikatorSasaran::findOne(['indikator_id' => $indikator_id, 'tahun_id' => $tahun_id])) !== null) {
            return $model;
        }
    
        // Jika model tidak ditemukan, kembalikan null
        return null;
    }
    


    /**
     * Deletes an existing TargetIndikatorSasaran model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $indikator_id Indikator ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($indikator_id)
    {
        $this->findModels($indikator_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TargetIndikatorSasaran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $indikator_id Indikator ID
     * @return TargetIndikatorSasaran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModels($indikator_id)
    {
        if (($model = TargetIndikatorSasaran::findOne(['indikator_id' => $indikator_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
