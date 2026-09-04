<?php

namespace backend\controllers;

use Yii;
use backend\models\UnduhanFile;
use backend\models\search\UnduhanFileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\SecureFile;
use backend\models\Unduhan;
use backend\models\search\UnduhanSearch;
use backend\models\Bidang;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\web\Response;
use backend\models\Pegawai;
use backend\models\PegawaiEselon;
use backend\models\Title;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\Expression;

/**
 * UnduhanFileController implements the CRUD actions for UnduhanFile model.
 */
class UnduhanFileController extends Controller
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
     * Lists all UnduhanFile models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UnduhanFileSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        // Menonaktifkan paginasi
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UnduhanFile model.
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
     * Creates a new UnduhanFile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($refunduhan_id)
    {
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
            $model = new UnduhanFile();

            $model->refunduhan_id = $refunduhan_id;

            $unduhan = Unduhan::findOne($refunduhan_id);

            if ($this->request->isPost) {
                $model->file_docs = UploadedFile::getInstances($model, 'file_docs');

                // Validate and process each uploaded file
                foreach ($model->file_docs as $uploadedFile) {
                    $newModel = new UnduhanFile(); // create a new instance for each file

                    // Load other attributes
                    $newModel->load($this->request->post());
                    $newModel->refunduhan_id = $model->refunduhan_id; // Assign refunduhan_id to the new instance

                    // Set the file attribute and save the file
                    $newModel->file = SecureFile::safeName($uploadedFile);

                    $newModel->tanggalUpload = date('Y-m-d'); // Format: TAHUN-BULAN-TANGGAL

                    $lokasi_simpan = Yii::getAlias('@frontend/web/uploads/unduhan/') . $newModel->file;
                    $lokasi_simpan2 = Yii::getAlias('@backend/web/uploads/unduhan/') . $newModel->file;

                    $uploadedFile->saveAs($lokasi_simpan, false);
                    $uploadedFile->saveAs($lokasi_simpan2, false);

                    if ($newModel->save()) {
                        // Success message if needed
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to save the model.');
                    }
                }
                Yii::$app->session->setFlash('success', 'Berhasil Menambah File');
                return $this->redirect(['unduhan/view', 'id' => $unduhan->id]); // Redirect to Unduhan ID
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
            return $this->redirect(['site/login']);
        }
    }


    public function actionUpdate($id)
    {
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
            $model = UnduhanFile::findOne($id);

            if (!$model) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }

            // Simpan kategori_id untuk penggunaan redirect
            $refunduhan_id = $model->refunduhan_id;

            if ($this->request->isPost) {
                $model->file_doc = UploadedFile::getInstances($model, 'file_doc');

                // Validate and process each uploaded file
                foreach ($model->file_doc as $uploadedFile) {
                    // Load other attributes
                    $model->load($this->request->post());

                    // Set the file attribute and save the file
                    $model->file = SecureFile::safeName($uploadedFile);

                    $lokasi_simpan = Yii::getAlias('@frontend/web/uploads/unduhan/') . $model->file;
                    $lokasi_simpan2 = Yii::getAlias('@backend/web/uploads/unduhan/') . $model->file;

                    $uploadedFile->saveAs($lokasi_simpan, false);
                    $uploadedFile->saveAs($lokasi_simpan2, false);


                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Berhasil mengupdate File.');
                    } else {
                        Yii::$app->session->setFlash('error', 'Gagal menyimpan perubahan.');
                    }
                }

                return $this->redirect(['unduhan/view', 'id' => $refunduhan_id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
            return $this->redirect(['site/login']);
        }
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
        $model = $this->findModel($id);

        // Simpan kategori_id untuk digunakan dalam redirect
        $refunduhan_id = $model->unduhan->id;

        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
            $model->delete();
            // Set flash message untuk notifikasi
            Yii::$app->session->setFlash('success', 'Berhasil Menghapus File');
            return $this->redirect(['unduhan/view', 'id' => $refunduhan_id]);
        } else {
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
            return $this->redirect(['site/login']);
        }
    }

    public function actionDownload($id)
    {
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
            $model = $this->findModel($id);

            // Adjust the path based on how you store your files
            return SecureFile::send('unduhan', $model->file, $model->file);
        } else {
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Finds the UnduhanFile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UnduhanFile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UnduhanFile::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}