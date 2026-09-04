<?php

namespace frontend\controllers;

use yii\filters\VerbFilter;
use Yii;
use frontend\models\Unduhan;
use frontend\models\search\UnduhanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\models\UnduhanFile;
use frontend\models\Profil;
use frontend\models\search\UnduhanFileSearch;
use frontend\models\Bidang;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\Expression;

/**
 * UnduhanController implements the CRUD actions for Unduhan model.
 */
class UnduhanController extends Controller
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
     * Lists all Unduhan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UnduhanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        // Menonaktifkan paginasi
        $dataProvider->pagination = false;

        // Mengambil semua Bidang beserta relasi unduhans, dan untuk setiap unduhan, ambil unduhanFiles-nya
        $bidangs = Bidang::find()
            ->with([
                'unduhans' => function ($query) {
                    // Anda bisa menambahkan order by untuk unduhan jika perlu
                    $query->orderBy(['namaFile' => SORT_ASC]);
                },
                'unduhans.unduhanFiles' => function ($query) {
                    // Anda bisa menambahkan order by untuk unduhan file jika perlu
                    $query->orderBy(['tanggalUpload' => SORT_DESC, 'file' => SORT_ASC]);
                }
            ])
            // Anda bisa menambahkan order by untuk bidang jika perlu
            // ->orderBy(['bidang' => SORT_ASC])
            ->all();

        $profils = Profil::find()->orderBy(['tanggalUpload' => SORT_DESC])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'bidangs' => $bidangs,
            'profils' => $profils,
        ]);
    }

    /**
     * Displays a single Unduhan model.
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
     * Creates a new Unduhan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Unduhan();

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
     * Updates an existing Unduhan model.
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
     * Deletes an existing Unduhan model.
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
     * Finds the Unduhan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Unduhan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Unduhan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
