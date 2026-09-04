<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\SecureFile;
use backend\models\BeritaAlt;
use backend\models\search\BeritaAltSearch;
use backend\models\Berita;
use backend\models\search\BeritaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\web\Response;

/**
 * BeritaAltController implements the CRUD actions for BeritaAlt model.
 */
class BeritaAltController extends Controller
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
     * Lists all BeritaAlt models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BeritaAltSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        // Menonaktifkan paginasi
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BeritaAlt model.
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
     * Creates a new BeritaAlt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($berita_id)
    {
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator']) ) {
        $model = new BeritaAlt();
        
        $model->berita_id = $berita_id;
        
        $berita = Berita::findOne($berita_id);
        
        if ($this->request->isPost) {
            $model->file_docs = UploadedFile::getInstances($model, 'file_docs');
        
            // Validate and process each uploaded file
            foreach ($model->file_docs as $uploadedFile) {
                $newModel = new BeritaAlt(); // create a new instance for each file
    
                // Load other attributes
                $newModel->load($this->request->post());
                $newModel->berita_id = $model->berita_id; // Assign berita_id to the new instance
    
                // Set the file attribute and save the file
                $newModel->file = SecureFile::safeName($uploadedFile);
    
                $lokasi_simpan = Yii::getAlias('@frontend/web/uploads/berita_alt/') . $newModel->file;
                $lokasi_simpan2 = Yii::getAlias('@backend/web/uploads/berita_alt/') . $newModel->file;
    
                $uploadedFile->saveAs($lokasi_simpan, false);
                $uploadedFile->saveAs($lokasi_simpan2, false);
    
                if ($newModel->save()) {
                    // Success message if needed
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save the model.');
                }
            }
            Yii::$app->session->setFlash('success', 'Berhasil Menambah Tambahan Gambar Berita Perencanaan');
            return $this->redirect(['berita/view', 'id' => $berita->id]); // Redirect to Berita ID
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
        }else{
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
            return $this->redirect(['site/login']);
        }
    }
    

    public function actionUpdate($id)
    {
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator']) ) {
        $model = BeritaAlt::findOne($id);
    
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    
        // Simpan kategori_id untuk penggunaan redirect
        $berita_id = $model->berita_id;
    
        if ($this->request->isPost) {
            $model->file_doc = UploadedFile::getInstances($model, 'file_doc');
    
            // Validate and process each uploaded file
            foreach ($model->file_doc as $uploadedFile) {
                // Load other attributes
                $model->load($this->request->post());
    
                // Set the file attribute and save the file
                $model->file = SecureFile::safeName($uploadedFile);
    
                $lokasi_simpan = Yii::getAlias('@frontend/web/uploads/berita_alt/') . $model->file;
                $lokasi_simpan2 = Yii::getAlias('@backend/web/uploads/berita_alt/') . $model->file;
    
                $uploadedFile->saveAs($lokasi_simpan, false);
                $uploadedFile->saveAs($lokasi_simpan2, false);

    
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Berhasil mengupdate gambar.');
                } else {
                    Yii::$app->session->setFlash('error', 'Gagal menyimpan perubahan.');
                }
            }

            return $this->redirect(['berita/view', 'id' => $berita_id]);
        }
    
            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Deletes an existing BeritaAlt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
    
        // Simpan kategori_id untuk digunakan dalam redirect
        $berita_id = $model->berita->id;

        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
            $model->delete();
            // Set flash message untuk notifikasi
            Yii::$app->session->setFlash('success', 'Berhasil Menghapus Gambar Berita Perencanaan');
            return $this->redirect(['berita/view', 'id' => $berita_id]);
        } else {
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
            return $this->redirect(['site/login']);
        }
    }

    public function actionDownload($id)
    {
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator']) ) {
        $model = $this->findModel($id);
    
        // Adjust the path based on how you store your files
        return SecureFile::send('berita_alt', $model->file, $model->file);
    }else{
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
        return $this->redirect(['site/login']);
    }
    }


    /**
     * Finds the BeritaAlt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return BeritaAlt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BeritaAlt::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}