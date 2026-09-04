<?php

namespace backend\controllers;

use Yii;
use backend\models\SampahDokumen;
use backend\models\search\SampahDokumenSearch;
use backend\models\DataSampah;
use backend\models\search\DataSampahSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\web\Response;
use yii\helpers\Json;


/**
 * SampahDokumenController implements the CRUD actions for SampahDokumen model.
 */
class SampahDokumenController extends Controller
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
     * Lists all SampahDokumen models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SampahDokumenSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SampahDokumen model.
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
     * Creates a new SampahDokumen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($kodeDataSampah)
    {
        $model = new SampahDokumen();
        
        $model->kodeDataSampah = $kodeDataSampah;
        
        $datasampah = DataSampah::findOne($kodeDataSampah);
        
        if ($this->request->isPost) {
            $model->file_docs = UploadedFile::getInstances($model, 'file_docs');
        
            // Validate and process each uploaded file
            foreach ($model->file_docs as $uploadedFile) {
                $newModel = new SampahDokumen(); // create a new instance for each file
    
                // Load other attributes
                $newModel->load($this->request->post());
                $newModel->kodeDataSampah = $model->kodeDataSampah; // Assign berita_id to the new instance
    
                // Set the file attribute and save the file
                $newModel->file = $uploadedFile->baseName . '.' . $uploadedFile->extension;
    
                $lokasi_simpan = Yii::getAlias('@frontend/web/dokumen/data_sampah_image/') . $newModel->file;
                $lokasi_simpan2 = Yii::getAlias('@backend/web/dokumen/data_sampah_image/') . $newModel->file;
    
                $uploadedFile->saveAs($lokasi_simpan, false);
                $uploadedFile->saveAs($lokasi_simpan2, false);
    
                if ($newModel->save()) {
                    // Success message if needed
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save the model.');
                }
            }
            Yii::$app->session->setFlash('success', 'Berhasil Menambah Gambar');
            return $this->redirect(['data-sampah/view', 'id' => $datasampah->id]); // Redirect to Berita ID
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
        
    }



    public function actionGetImage($kodeDataSampah)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $sampahDokumen = \backend\models\SampahDokumen::find()->where(['kodeDataSampah' => $kodeDataSampah])->one();
        
        if ($sampahDokumen) {
            return [
                'success' => true,
                'imageUrl' => Url::to(['/dokumen/data_sampah_image/' . $sampahDokumen->file], true),
            ];
        } else {
            return [
                'success' => false,
            ];
        }
    }
    

    

    public function actionUpdate($id)
    {
        $model = SampahDokumen::findOne($id);
    
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    
        // Simpan kategori_id untuk penggunaan redirect
        $kodeDataSampah = $model->kodeDataSampah;
    
        if ($this->request->isPost) {
            $model->file_doc = UploadedFile::getInstances($model, 'file_doc');
    
            // Validate and process each uploaded file
            foreach ($model->file_doc as $uploadedFile) {
                // Load other attributes
                $model->load($this->request->post());
    
                // Set the file attribute and save the file
                $model->file = $uploadedFile->baseName . '.' . $uploadedFile->extension;
    
                $lokasi_simpan = Yii::getAlias('@frontend/web/dokumen/data_sampah_image/') . $model->file;
                $lokasi_simpan2 = Yii::getAlias('@backend/web/dokumen/data_sampah_image/') . $model->file;
    
                $uploadedFile->saveAs($lokasi_simpan, false);
                $uploadedFile->saveAs($lokasi_simpan2, false);

    
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Berhasil mengupdate gambar.');
                } else {
                    Yii::$app->session->setFlash('error', 'Gagal menyimpan perubahan.');
                }
            }

            return $this->redirect(['data-sampah/view', 'id' => $kodeDataSampah]);
        }
    
            return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing IpaldDokumen model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
    
        // Simpan kategori_id untuk digunakan dalam redirect
        $kodeDataSampah = $model->datasampah->id;
            $model->delete();
            // Set flash message untuk notifikasi
            Yii::$app->session->setFlash('success', 'Berhasil Menghapus Gambar');
            return $this->redirect(['data-sampah/view', 'id' => $kodeDataSampah]);
    }

    public function actionDownload($id)
    {
        $model = $this->findModel($id);
    
        // Adjust the path based on how you store your files
        $filePath = 'dokumen/data_sampah_image/' . $model->file;
    
        if (file_exists($filePath)) {
            Yii::$app->response->sendFile($filePath);
        } else {
            throw new \yii\web\NotFoundHttpException('The requested file does not exist.');
        }
    }

    /**
     * Finds the SampahDokumen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SampahDokumen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SampahDokumen::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
