<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use backend\models\Berita;
use backend\models\BeritaAlt;
use backend\models\Bidang;
use backend\models\search\BeritaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
        // Dapatkan bidang_id dari pengguna yang sedang login
        $userBidangId = Yii::$app->user->identity->bidang_id;
    
        // Buat objek search model dan kueri dataProvider
        $searchModel = new BeritaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['kabid'])) {

        // Filter dataProvider hanya untuk bidang_id yang sesuai dengan bidang_id pengguna yang login saat ini
        $dataProvider->query->andFilterWhere(['bidang_id' => $userBidangId]);
        // Menambahkan pengaturan orderBy untuk mengurutkan hasil berita berdasarkan tgl_berita secara terbalik (terbaru ke yang paling lama)
        $dataProvider->query->orderBy(['tgl_berita' => SORT_DESC]);
        }
         // Menambahkan pengaturan orderBy untuk mengurutkan hasil berita berdasarkan tgl_berita secara terbalik (terbaru ke yang paling lama)
        $dataProvider->query->orderBy(['tgl_berita' => SORT_DESC]);
        // Menonaktifkan paginasi
        $dataProvider->pagination = false;
    
        // Render view index dengan data yang sudah difilter
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        // Dapatkan data berita berdasarkan ID
        $model = $this->findModel($id);
    
        // Dapatkan bidang_id dari pengguna yang sedang login
        $userBidangId = Yii::$app->user->identity->bidang_id;
    
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['kabid'])) {
        // Periksa apakah bidang_id dari berita sama dengan bidang_id dari pengguna yang login
        if ($model->bidang_id !== $userBidangId) {
            throw new NotFoundHttpException('The requested page does not exist.');
            // Atau Anda dapat mengarahkan pengguna kembali ke halaman sebelumnya atau halaman tertentu
            // return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }
    }
    
        return $this->render('view', [
            'model' => $model,
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
        $model->file_doc = UploadedFile::getInstances($model, 'file_doc');

        // Validate and process each uploaded file
        if (!empty($model->file_doc)) {
            foreach ($model->file_doc as $uploadedFile) {
                $model->file = $uploadedFile->baseName . '.' . $uploadedFile->extension;

                $lokasi_simpan = Yii::getAlias('@frontend/web/uploads/berita/') . $model->file;
                $lokasi_simpan2 = Yii::getAlias('@backend/web/uploads/berita/') . $model->file;

                $uploadedFile->saveAs($lokasi_simpan, false);
                $uploadedFile->saveAs($lokasi_simpan2, false);
            }
        }

        // Load other attributes
        $model->load($this->request->post());

        if ($model->save()) {
            // Fetch the relevant pegawai records
            $pegawaiList = \backend\models\Pegawai::find()
                ->where(['kodeTitle' => 2, 'kodeBidang' => $model->bidang_id])
                ->all();

            // Prepare and send the WhatsApp message
            foreach ($pegawaiList as $pegawai) {
                $message = "Halo, ada berita perencanaan baru dari bidang anda yang telah dibuat untuk di publish ke Website Bappedalitbang.\n"
                         . "Detail:\n"
                         . "Judul Berita: \n*{$model->judulBerita}*\n\n"
                         . "Tanggal Berita: *{$model->tgl_berita}*\n"
                         . "Bidang Berita: *{$model->bidang->bidang}*\n"
                         . "Status: *Review*\n\n"
                         . "*Mohon berita agar segera di review dan disetujui untuk publish ke Website Bappedalitbang.*\n"
                         . "Terimakasih!!\n\n"
                         . "bappedalitbang.deliserdangkab.go.id/admin";

                $this->sendWhatsAppNotification($pegawai->no_hp, $message);
            }

            Yii::$app->session->setFlash('success', 'Berhasil Mengupload Berita');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            Yii::$app->session->setFlash('error', 'Failed to save the model.');
        }
    }

    return $this->render('create', [
        'model' => $model,
    ]);
}

protected function sendWhatsAppNotification($receiverNumber, $message)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://app.saungwa.com/api/create-message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => [
  'appkey' => '861074a2-79e8-46bf-9455-e12ccdbc1a55',
  'authkey' => 'yBzR9LniWynYt6hMm5fuBfOOu3bv1KrclWpwaPSeWsANIho7eq',
            'to' => $receiverNumber,
            'message' => $message,
            'sandbox' => 'false'
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
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

    if ($this->request->isPost) {
        $model->file_doc = UploadedFile::getInstances($model, 'file_doc');

        // Validate and process each uploaded file
        if (!empty($model->file_doc)) {
            foreach ($model->file_doc as $uploadedFile) {
                // Set file name
                $model->file = $uploadedFile->baseName . '.' . $uploadedFile->extension;

                // Define file paths
                $lokasi_simpan = Yii::getAlias('@frontend/web/uploads/berita/') . $model->file;
                $lokasi_simpan2 = Yii::getAlias('@backend/web/uploads/berita/') . $model->file;

                // Save files
                $uploadedFile->saveAs($lokasi_simpan, false);
                $uploadedFile->saveAs($lokasi_simpan2, false);
            }
        }

        // Load other attributes
        if ($model->load($this->request->post()) && $model->save()) {
            $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
            if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
                // Fetch the relevant pegawai records
                $pegawaiList = \backend\models\Pegawai::find()
                    ->where(['kodeTitle' => 2, 'kodeBidang' => $model->bidang_id])
                    ->all();

                // Prepare and send the WhatsApp message
                foreach ($pegawaiList as $pegawai) {
                    $message = "Halo, berita perencanaan dari bidang anda telah diperbarui untuk dipublish ke Website Bappedalitbang.\n"
                             . "Detail Berita:\n"
                             . "Judul Berita: {$model->judulBerita}\n"
                             . "Tanggal Berita: {$model->tgl_berita}\n"
                             . "Bidang Berita: {$model->bidang->bidang}\n"
                             . "Status: Review\n"
                             . "Keterangan: {$model->keterangan}\n\n"
                             . "Mohon berita agar segera di review dan disetujui untuk publish ke Website Bappedalitbang.\n"
                             . "Terimakasih!!\n\n"
                             . "bappedalitbang.deliserdangkab.go.id/admin";

                    $this->sendWhatsAppNotificationUpdate($pegawai->no_hp, $message);
                }
            }

            if (isset($assignments['kabid'])) {
                // Prepare and send the WhatsApp message to the specific number
                $message = "Halo, berita perencanaan dari bidang {$model->bidang->bidang} telah disetujui untuk dipublish ke Website Bappedalitbang.\n"
                         . "Detail Berita:\n"
                         . "Judul Berita: {$model->judulBerita}\n"
                         . "Tanggal Berita: {$model->tgl_berita}\n"
                         . "Bidang Berita: {$model->bidang->bidang}\n"
                         . "Status: Review\n"
                         . "Keterangan: {$model->keterangan}\n\n"
                         . "Mohon periksa kembali berita yang telah disetujui.\n"
                         . "Terimakasih!!\n\n"
                         . "bappedalitbang.deliserdangkab.go.id/admin";

                $this->sendWhatsAppNotificationUpdate('6281265673656', $message);
            }

            Yii::$app->session->setFlash('success', 'Berhasil Mengupdate Berita');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            Yii::$app->session->setFlash('error', 'Failed to update the model.');
        }
    }

    return $this->render('update', [
        'model' => $model,
    ]);
}

protected function sendWhatsAppNotificationUpdate($receiverNumber, $message)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://app.saungwa.com/api/create-message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => [
            'appkey' => '20491faa-cc2b-4fda-87a6-229d72880097',
            'authkey' => 'yBzR9LniWynYt6hMm5fuBfOOu3bv1KrclWpwaPSeWsANIho7eq',
            'to' => $receiverNumber,
            'message' => $message,
            'sandbox' => 'false'
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

    public function actionPreview($id)
    {
        $this->layout = 'main-front';
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

        return $this->render('preview', [
            'model' => $this->findModel($id),
            'latestBerita' => $latestBerita,
            'queryBidang' => $queryBidang, // Pass data bidang ke view
            'gambarBeritaAlt' => $gambarBeritaAlt, // Pass daftar gambar berita-alt ke view
'beritaAlts' => $beritaAlts, // Pass data berita-alt ke view
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
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
            // Ambil model berita yang akan dihapus
            $model = $this->findModel($id);
    
            // Simpan id berita untuk penggunaan dalam redirect
            $berita_id = $model->id;
    
            // Hapus berita_alt yang memiliki berita_id yang sama dengan id berita yang akan dihapus
            BeritaAlt::deleteAll(['berita_id' => $berita_id]);
    
            // Hapus berita
            $model->delete();
    
            Yii::$app->session->setFlash('success', 'Berhasil menghapus berita dan gambar tambahannya.');
            return $this->redirect(['index']);
        } else {
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silakan login kembali');
            return $this->redirect(['site/login']);
        }
    }

    public function actionDownload($id)
    {
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
        if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator']) ) {
        $model = $this->findModel($id);
    
        // Adjust the path based on how you store your files
        $filePath = 'uploads/berita/' . $model->file;
    
        if (file_exists($filePath)) {
            Yii::$app->response->sendFile($filePath);
        } else {
            throw new \yii\web\NotFoundHttpException('The requested file does not exist.');
        }
    }else{
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('error', 'Anda tidak dapat mengakses halaman tersebut, silahkan login kembali');
        return $this->redirect(['site/login']);
    }
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
