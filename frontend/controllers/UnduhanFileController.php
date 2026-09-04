<?php

namespace frontend\controllers;

use Yii;
use frontend\models\UnduhanFile;
use frontend\models\search\UnduhanFileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UnduhanFileController implements the CRUD actions for UnduhanFile model.
 */
class UnduhanFileController extends Controller
{
    /**
     * Folder tunggal tempat semua file unduhan disimpan.
     * Semua operasi baca/tulis dikurung di dalam folder ini.
     */
    const UPLOAD_DIR = '@frontend/web/uploads/unduhan';

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
                        [
                            // publik hanya boleh melihat dan mengunduh
                            'allow'   => true,
                            'actions' => ['index', 'view', 'download'],
                            'roles'   => ['?', '@'],
                        ],
                        [
                            // menambah, mengubah, menghapus wajib login
                            'allow'   => true,
                            'actions' => ['create', 'update', 'delete'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class'   => VerbFilter::class,
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
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UnduhanFile();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $upload = UploadedFile::getInstance($model, 'file');

                if ($upload !== null) {
                    $model->file = $upload;

                    if (!$model->validate()) {
                        return $this->render('create', ['model' => $model]);
                    }

                    $nama = $this->simpanFile($upload);
                    if ($nama === null) {
                        $model->addError('file', 'Gagal menyimpan file.');
                        return $this->render('create', ['model' => $model]);
                    }

                    $model->file = $nama;
                }

                if ($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UnduhanFile model.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $fileLama = $model->file;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $upload = UploadedFile::getInstance($model, 'file');

            if ($upload !== null) {
                $model->file = $upload;

                if (!$model->validate()) {
                    return $this->render('update', ['model' => $model]);
                }

                $nama = $this->simpanFile($upload);
                if ($nama === null) {
                    $model->addError('file', 'Gagal menyimpan file.');
                    return $this->render('update', ['model' => $model]);
                }

                $model->file = $nama;
            } else {
                // tidak ada file baru diunggah, pertahankan yang lama
                $model->file = $fileLama;
            }

            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UnduhanFile model.
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
     * Mengirim file unduhan.
     *
     * Nama file dari database diperlakukan sebagai data tidak dipercaya.
     * Jalur akhir dikurung di dalam UPLOAD_DIR memakai realpath.
     *
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     */
    public function actionDownload($id)
    {
        $model = $this->findModel($id);

        // buang seluruh komponen direktori, sisakan nama file saja
        $nama = basename((string) $model->file);

        if ($nama === '' || $nama === '.' || $nama === '..') {
            throw new BadRequestHttpException('Nama file tidak valid.');
        }

        $baseDir = realpath(Yii::getAlias(self::UPLOAD_DIR));
        if ($baseDir === false) {
            throw new NotFoundHttpException('Folder unduhan tidak tersedia.');
        }

        $target = realpath($baseDir . DIRECTORY_SEPARATOR . $nama);

        // realpath mengembalikan false jika file tidak ada,
        // dan hasilnya harus benar-benar berada di dalam $baseDir
        if ($target === false
            || strncmp($target, $baseDir . DIRECTORY_SEPARATOR, strlen($baseDir) + 1) !== 0
            || !is_file($target)
        ) {
            Yii::warning(
                'Percobaan akses file di luar folder unduhan: ' . $model->file
                . ' dari IP ' . Yii::$app->request->userIP,
                'security'
            );
            throw new NotFoundHttpException('File tidak ditemukan.');
        }

        return Yii::$app->response->sendFile($target, $nama);
    }

    /**
     * Menyimpan file unggahan dengan nama yang dibuat ulang.
     *
     * @param UploadedFile $upload
     * @return string|null nama file yang disimpan, atau null jika gagal
     */
    protected function simpanFile(UploadedFile $upload)
    {
        $dir = Yii::getAlias(self::UPLOAD_DIR);

        if (!is_dir($dir)) {
            FileHelper::createDirectory($dir, 0770, true);
        }

        $ext  = strtolower(preg_replace('/[^A-Za-z0-9]/', '', (string) $upload->extension));
        $nama = Yii::$app->security->generateRandomString(24) . ($ext !== '' ? '.' . $ext : '');

        if (!$upload->saveAs($dir . DIRECTORY_SEPARATOR . $nama, false)) {
            return null;
        }

        return $nama;
    }

    /**
     * Finds the UnduhanFile model based on its primary key value.
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