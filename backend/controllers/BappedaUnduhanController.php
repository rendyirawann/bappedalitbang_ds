<?php

namespace backend\controllers;

use backend\models\BappedaUnduhan;
use backend\models\search\BappedaUnduhanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BappedaUnduhanController implements the CRUD actions for BappedaUnduhan model.
 */
class BappedaUnduhanController extends Controller
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
     * Lists all BappedaUnduhan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BappedaUnduhanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BappedaUnduhan model.
     * @param int $refunduhan_id Refunduhan ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($refunduhan_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($refunduhan_id),
        ]);
    }

    /**
     * Creates a new BappedaUnduhan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new BappedaUnduhan();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'refunduhan_id' => $model->refunduhan_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BappedaUnduhan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $refunduhan_id Refunduhan ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($refunduhan_id)
    {
        $model = $this->findModel($refunduhan_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'refunduhan_id' => $model->refunduhan_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BappedaUnduhan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $refunduhan_id Refunduhan ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($refunduhan_id)
    {
        $this->findModel($refunduhan_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BappedaUnduhan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $refunduhan_id Refunduhan ID
     * @return BappedaUnduhan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($refunduhan_id)
    {
        if (($model = BappedaUnduhan::findOne(['refunduhan_id' => $refunduhan_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
