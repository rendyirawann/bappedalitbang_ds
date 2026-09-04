<?php

namespace backend\controllers;

use Yii;
use backend\models\StandarPelayanan;
use backend\models\search\StandarPelayananSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\SecureFile;
use yii\web\UploadedFile;

/**
 * StandarPelayananController implements the CRUD actions for StandarPelayanan model.
 */
class StandarPelayananController extends Controller
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
     * Lists all StandarPelayanan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['superadmin']) || isset($assignments['admin'])) {
            $searchModel = new StandarPelayananSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);

            // Menonaktifkan paginasi
            $dataProvider->pagination = false;

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Displays a single StandarPelayanan model.
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
     * Creates new StandarPelayanan models (mendukung upload batch/banyak file sekaligus).
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new StandarPelayanan();

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->file_docs = UploadedFile::getInstances($model, 'file_docs');

            if (empty($model->file_docs)) {
                Yii::$app->session->setFlash('error', 'File dokumen wajib diupload.');
            } elseif ($model->validate()) {
                $jumlahFile = count($model->file_docs);
                $namaDasar = trim((string) $model->namaFile);

                foreach ($model->file_docs as $index => $uploadedFile) {
                    $row = new StandarPelayanan();
                    $row->tahun = $model->tahun;

                    if ($namaDasar === '') {
                        // Pakai nama file asli sebagai nama dokumen
                        $row->namaFile = ucwords(trim(preg_replace('/[-_]+/', ' ', $uploadedFile->baseName)));
                    } elseif ($jumlahFile > 1) {
                        $row->namaFile = $namaDasar . ' (' . ($index + 1) . ')';
                    } else {
                        $row->namaFile = $namaDasar;
                    }

                    $row->file = $this->saveUploadedFile($uploadedFile);
                    $row->save(false);
                }

                Yii::$app->session->setFlash('success', 'Berhasil Mengupload ' . $jumlahFile . ' Dokumen Standar Pelayanan');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StandarPelayanan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->file_doc = UploadedFile::getInstance($model, 'file_doc');

            if (trim((string) $model->namaFile) === '') {
                // Jangan biarkan nama dokumen kosong saat update
                $model->namaFile = $model->getOldAttribute('namaFile');
            }

            if ($model->validate()) {
                if ($model->file_doc) {
                    $model->file = $this->saveUploadedFile($model->file_doc);
                }

                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Berhasil Mengupdate Dokumen Standar Pelayanan');
                    return $this->redirect(['view', 'id' => $model->id]);
                }

                Yii::$app->session->setFlash('error', 'Failed to update the model.');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StandarPelayanan model.
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
        if (isset($assignments['superadmin']) || isset($assignments['admin'])) {
            $model = $this->findModel($id);

            return SecureFile::send('standar-pelayanan', $model->file, $model->file);
        } else {
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Menyimpan file upload ke folder uploads frontend & backend
     * dengan nama file yang aman (tanpa spasi/karakter khusus).
     *
     * @param UploadedFile $uploadedFile
     * @return string nama file yang tersimpan
     */
    protected function saveUploadedFile($uploadedFile)
    {
        $safeName = preg_replace('/[^A-Za-z0-9\-_]/', '-', $uploadedFile->baseName);
        $safeName = trim(preg_replace('/-+/', '-', $safeName), '-');
        $extension = strtolower($uploadedFile->extension);

        \yii\helpers\FileHelper::createDirectory(Yii::getAlias('@frontend/web/uploads/standar-pelayanan'));
        \yii\helpers\FileHelper::createDirectory(Yii::getAlias('@backend/web/uploads/standar-pelayanan'));

        // Hindari nama file tabrakan (misal upload batch dengan nama sama)
        $fileName = time() . '-' . strtolower($safeName) . '.' . $extension;
        $counter = 1;
        while (file_exists(Yii::getAlias('@frontend/web/uploads/standar-pelayanan/') . $fileName)) {
            $fileName = time() . '-' . strtolower($safeName) . '-' . $counter++ . '.' . $extension;
        }

        $lokasi_simpan = Yii::getAlias('@frontend/web/uploads/standar-pelayanan/') . $fileName;
        $lokasi_simpan2 = Yii::getAlias('@backend/web/uploads/standar-pelayanan/') . $fileName;

        $uploadedFile->saveAs($lokasi_simpan, false);
        $uploadedFile->saveAs($lokasi_simpan2, false);

        return $fileName;
    }

    /**
     * Finds the StandarPelayanan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return StandarPelayanan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StandarPelayanan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}