<?php

namespace backend\controllers;

use Yii;
use backend\models\Profil;
use backend\models\search\ProfilSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\SecureFile;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\Expression;

/**
 * ProfilController implements the CRUD actions for Profil model.
 */
class ProfilController extends Controller
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
     * Lists all Profil models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProfilSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        // Menonaktifkan paginasi
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profil model.
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
     * Creates a new Profil model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Profil();

        if ($this->request->isPost) {
            $model->file_doc = UploadedFile::getInstances($model, 'file_doc');
            $model->tanggalUpload = date('Y-m-d'); // Format: TAHUN-BULAN-TANGGAL

            // Validate and process each uploaded file
            if (!empty($model->file_doc)) {
                foreach ($model->file_doc as $uploadedFile) {
                    $model->file = SecureFile::safeName($uploadedFile);
                    $model->tanggalUpload = date('Y-m-d'); // Format: TAHUN-BULAN-TANGGAL

                    $lokasi_simpan = Yii::getAlias('@frontend/web/uploads/profil/') . $model->file;
                    $lokasi_simpan2 = Yii::getAlias('@backend/web/uploads/profil/') . $model->file;

                    $uploadedFile->saveAs($lokasi_simpan, false);
                    $uploadedFile->saveAs($lokasi_simpan2, false);
                }
            }
            // Load other attributes
            $model->load($this->request->post());
            $model->tanggalUpload = date('Y-m-d'); // Format: TAHUN-BULAN-TANGGAL
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Berhasil Mengupload File');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to save the model.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Profil model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->file_doc = UploadedFile::getInstances($model, 'file_doc');

            // Validate and process each uploaded file
            if (!empty($model->file_doc)) {
                foreach ($model->file_doc as $uploadedFile) {
                    // Set file name
                    $model->file = SecureFile::safeName($uploadedFile);

                    // Define file paths
                    $lokasi_simpan = Yii::getAlias('@frontend/web/uploads/profil/') . $model->file;
                    $lokasi_simpan2 = Yii::getAlias('@backend/web/uploads/profil/') . $model->file;

                    // Save files
                    $uploadedFile->saveAs($lokasi_simpan, false);
                    $uploadedFile->saveAs($lokasi_simpan2, false);
                }
            }

            // Load other attributes
            if ($model->load($this->request->post()) && $model->save()) {
                $model->tanggalUpload = date('Y-m-d'); // Format: TAHUN-BULAN-TANGGAL

                Yii::$app->session->setFlash('success', 'Berhasil Mengupdate File');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update the model.');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Profil model.
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
        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
            $model = $this->findModel($id);

            // Adjust the path based on how you store your files
            return SecureFile::send('profil', $model->file, $model->file);
        } else {
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Finds the Profil model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Profil the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profil::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}