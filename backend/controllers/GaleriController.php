<?php

namespace backend\controllers;

use Yii;
use backend\models\Galeri;
use backend\models\search\GaleriSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\SecureFile;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\web\Response;

/**
 * GaleriController implements the CRUD actions for Galeri model.
 */
class GaleriController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        // Seluruh action di controller ini wajib login.
                        // Pemeriksaan peran per-action yang sudah ada
                        // (superadmin/admin/operator) tetap berjalan.
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
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
     * Lists all Galeri models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['superadmin']) || isset($assignments['admin'])) {
        $searchModel = new GaleriSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        // Menonaktifkan paginasi
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }else{
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
        return $this->redirect(['site/login']);
    }
    }

    /**
     * Displays a single Galeri model.
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
     * Creates a new Galeri model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Galeri();
    
      
        if ($this->request->isPost) {
            $model->file_docs = UploadedFile::getInstances($model, 'file_docs');
    
            // Validate and process each uploaded file
            foreach ($model->file_docs as $uploadedFile) {
                $model = new Galeri(); // create a new instance for each file

                // Load other attributes
                $model->load($this->request->post());

                // Set the file attribute and save the file
                $model->file = SecureFile::safeName($uploadedFile);

                $lokasi_simpan = Yii::getAlias('@frontend/web/uploads/galeri/') . $model->file;
                $lokasi_simpan2 = Yii::getAlias('@backend/web/uploads/galeri/') . $model->file;

                $uploadedFile->saveAs($lokasi_simpan, false);
                $uploadedFile->saveAs($lokasi_simpan2, false);

                if ($model->save()) {


                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save the model.');
                }
            }
        
            Yii::$app->session->setFlash('success', 'Berhasil Mengupload Galeri Kegiatan');
            return $this->redirect(['view', 'id' => $model->id]);
            
        }
    
        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Galeri model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
    
        if ($this->request->isPost) {
            $file_doc = UploadedFile::getInstance($model, 'file_doc');
    
            // Load other attributes
            if ($model->load($this->request->post())) {
    
                // Validate and process the uploaded file
                if ($file_doc) {
                    $model->file = SecureFile::safeName($file_doc);
    
                    $lokasi_simpan = Yii::getAlias('@frontend/web/uploads/galeri/') . $model->file;
                    $lokasi_simpan2 = Yii::getAlias('@backend/web/uploads/galeri/') . $model->file;
    
                    $file_doc->saveAs($lokasi_simpan, false);
                    $file_doc->saveAs($lokasi_simpan2, false);
                }
    
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Berhasil Mengupdate Galeri Kegiatan');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to update the model.');
                }
            }
        }
    
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Galeri model.
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

    public function actionDownload($id)
    {
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator']) ) {
        $model = $this->findModel($id);
    
        // Adjust the path based on how you store your files
        return SecureFile::send('galeri', $model->file, $model->file);
    }else{
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
        return $this->redirect(['site/login']);
    }
    }

    /**
     * Finds the Galeri model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Galeri the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Galeri::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}