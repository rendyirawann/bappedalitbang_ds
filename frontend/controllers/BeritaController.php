<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Berita;
use frontend\models\BeritaAlt;
use frontend\models\Bidang;
use frontend\models\search\BeritaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\Expression;

/**
 * BeritaController implements the CRUD actions for Berita model.
 */
class BeritaController extends Controller
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
     * Lists all Berita models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Berita::find()->where(['status' => '1'])->orderBy(['tgl_berita' => SORT_DESC]);
    
// Mengambil daftar bidang dan jumlah berita terkait
$queryBidang = Bidang::find()
    ->select(['bidang.id', 'bidang.bidang', 'COUNT(berita.id) as jumlah_berita'])
    ->leftJoin('berita', 'bidang.id = berita.bidang_id AND berita.status = 1')
    ->groupBy(['bidang.id', 'bidang.bidang'])
    ->asArray()
    ->all();

    
        $latestBerita = Berita::find()
            ->where(['status' => '1'])
            ->orderBy(['tgl_berita' => SORT_DESC])
            ->limit(3)
            ->all();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5, // Jumlah berita per halaman
            ],
        ]);
    
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'latestBerita' => $latestBerita,
            'queryBidang' => $queryBidang, // Pass data bidang ke view
        ]);
    }

    public function actionIndexBidang($bidang_id)
    {
        // Query untuk mendapatkan berita dengan bidang_id yang dipilih
        $query = Berita::find()->where(['status' => '1', 'bidang_id' => $bidang_id])->orderBy(['tgl_berita' => SORT_DESC]);

        // Mengambil nama bidang yang dipilih
        $bidang = Bidang::findOne($bidang_id);

        // Mengambil daftar bidang dan jumlah berita terkait
        $queryBidang = Bidang::find()
            ->select(['bidang.id', 'bidang.bidang', 'COUNT(berita.id) as jumlah_berita'])
            ->leftJoin('berita', 'bidang.id = berita.bidang_id AND berita.status = 1')
            ->groupBy(['bidang.id', 'bidang.bidang'])
            ->asArray()
            ->all();

        // Query untuk mendapatkan latestBerita yang hanya memiliki bidang_id yang dipilih
        $latestBerita = Berita::find()
            ->where(['status' => '1', 'bidang_id' => $bidang_id])
            ->orderBy(['tgl_berita' => SORT_DESC])
            ->limit(3)
            ->all();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5, // Jumlah berita per halaman
            ],
        ]);
                // Menonaktifkan paginasi
        $dataProvider->pagination = false;

        return $this->render('index-bidang', [
            'dataProvider' => $dataProvider,
            'latestBerita' => $latestBerita,
            'bidang' => $bidang,
            'queryBidang' => $queryBidang, // Pass data bidang ke view
        ]);
    }

    
    

    /**
     * Displays a single Berita model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // Retrieve the latest 4 news articles, excluding the current one
        $latestBerita = Berita::find()
        ->where(['status' => '1'])
        ->andWhere(['!=', 'id', $id])
        ->orderBy(['tgl_berita' => SORT_DESC])
        ->limit(3)
        ->all();

         // Mengambil daftar gambar berita-alt yang sesuai dengan berita saat ini
        $gambarBeritaAlt = BeritaAlt::find()
        ->select(['file'])
        ->where(['berita_id' => $id])
        ->asArray()
        ->all();

  // Mengambil berita-alt terkait dengan berita saat ini
    $beritaAlts = BeritaAlt::find()->where(['berita_id' => $id])->all();


        // Mengambil daftar bidang dan jumlah berita terkait
        $queryBidang = Bidang::find()
            ->select(['bidang.id', 'bidang.bidang', 'COUNT(berita.id) as jumlah_berita'])
            ->leftJoin('berita', 'bidang.id = berita.bidang_id AND berita.status = 1')
            ->groupBy(['bidang.id', 'bidang.bidang'])
            ->asArray()
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'latestBerita' => $latestBerita,
            'queryBidang' => $queryBidang, // Pass data bidang ke view
            'gambarBeritaAlt' => $gambarBeritaAlt, // Pass daftar gambar berita-alt ke view
'beritaAlts' => $beritaAlts, // Pass data berita-alt ke view
        ]);
    }


    /**
     * Creates a new Berita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Berita();

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
     * Updates an existing Berita model.
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
     * Deletes an existing Berita model.
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
     * Finds the Berita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Berita the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Berita::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
