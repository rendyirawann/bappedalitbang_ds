<?php

namespace backend\controllers;

use Yii;
use backend\models\IpaldDokumen;
use backend\models\search\IpaldDokumenSearch;
use backend\models\DataIpald;
use backend\models\search\DataIpaldSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\web\Response;
use yii\helpers\Json;

/**
 * IpaldDokumenController implements the CRUD actions for IpaldDokumen model.
 */
class IpaldDokumenController extends Controller
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
     * Lists all IpaldDokumen models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new IpaldDokumenSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IpaldDokumen model.
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
     * Creates a new IpaldDokumen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($kodeDataIpald)
    {
        $model = new IpaldDokumen();
        
        $model->kodeDataIpald = $kodeDataIpald;
        
        $dataipald = DataIpald::findOne($kodeDataIpald);
        
        if ($this->request->isPost) {
            $model->file_docs = UploadedFile::getInstances($model, 'file_docs');
        
            // Validate and process each uploaded file
            foreach ($model->file_docs as $uploadedFile) {
                $newModel = new IpaldDokumen(); // create a new instance for each file
    
                // Load other attributes
                $newModel->load($this->request->post());
                $newModel->kodeDataIpald = $model->kodeDataIpald; // Assign berita_id to the new instance
    
                // Set the file attribute and save the file
                $newModel->file = $uploadedFile->baseName . '.' . $uploadedFile->extension;
    
                $lokasi_simpan = Yii::getAlias('@frontend/web/dokumen/data_ipald_image/') . $newModel->file;
                $lokasi_simpan2 = Yii::getAlias('@backend/web/dokumen/data_ipald_image/') . $newModel->file;
    
                $uploadedFile->saveAs($lokasi_simpan, false);
                $uploadedFile->saveAs($lokasi_simpan2, false);
    
                if ($newModel->save()) {
                    // Success message if needed
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save the model.');
                }
            }
            Yii::$app->session->setFlash('success', 'Berhasil Menambah Gambar');
            return $this->redirect(['data-ipald/view', 'id' => $dataipald->id]); // Redirect to Berita ID
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
        
    }



    public function actionGetImage($kodeDataIpald)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $ipaldDokumen = \backend\models\IpaldDokumen::find()->where(['kodeDataIpald' => $kodeDataIpald])->one();
        
        if ($ipaldDokumen) {
            return [
                'success' => true,
                'imageUrl' => Url::to(['/dokumen/data_ipald_image/' . $ipaldDokumen->file], true),
            ];
        } else {
            return [
                'success' => false,
            ];
        }
    }
    

    

    public function actionUpdate($id)
    {
        $model = IpaldDokumen::findOne($id);
    
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    
        // Simpan kategori_id untuk penggunaan redirect
        $kodeDataIpald = $model->kodeDataIpald;
    
        if ($this->request->isPost) {
            $model->file_doc = UploadedFile::getInstances($model, 'file_doc');
    
            // Validate and process each uploaded file
            foreach ($model->file_doc as $uploadedFile) {
                // Load other attributes
                $model->load($this->request->post());
    
                // Set the file attribute and save the file
                $model->file = $uploadedFile->baseName . '.' . $uploadedFile->extension;
    
                $lokasi_simpan = Yii::getAlias('@frontend/web/dokumen/data_ipald_image/') . $model->file;
                $lokasi_simpan2 = Yii::getAlias('@backend/web/dokumen/data_ipald_image/') . $model->file;
    
                $uploadedFile->saveAs($lokasi_simpan, false);
                $uploadedFile->saveAs($lokasi_simpan2, false);

    
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Berhasil mengupdate gambar.');
                } else {
                    Yii::$app->session->setFlash('error', 'Gagal menyimpan perubahan.');
                }
            }

            return $this->redirect(['data-ipald/view', 'id' => $kodeDataIpald]);
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
        $kodeDataIpald = $model->dataipald->id;
            $model->delete();
            // Set flash message untuk notifikasi
            Yii::$app->session->setFlash('success', 'Berhasil Menghapus Gambar');
            return $this->redirect(['data-ipald/view', 'id' => $kodeDataIpald]);
    }

    public function actionDownload($id)
    {
        $model = $this->findModel($id);
    
        // Adjust the path based on how you store your files
        $filePath = 'dokumen/data_ipald_image/' . $model->file;
    
        if (file_exists($filePath)) {
            Yii::$app->response->sendFile($filePath);
        } else {
            throw new \yii\web\NotFoundHttpException('The requested file does not exist.');
        }
    }

    /**
     * Finds the IpaldDokumen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return IpaldDokumen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IpaldDokumen::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
