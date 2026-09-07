<?php

namespace backend\controllers;

use Yii;
use common\components\HeroImage;
use common\models\HeroSlider;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Pengelolaan banner hero pada halaman depan.
 *
 * HAK AKSES
 *   Hanya akun "developer" dan akun yang namanya diawali "admin"
 *   (admin, admin_nisa, admin_dila, admin_reza, ...). Tabel user pada
 *   aplikasi ini tidak punya kolom peran, dan bidang_id tidak bisa
 *   dipakai sebagai penanda karena nilainya bertabrakan dengan akun
 *   bidang biasa - admin_dila dan ppepd sama-sama bidang_id 1.
 *   Karena itu penyaringan dilakukan berdasarkan nama pengguna.
 *
 *   Menambah pengelola: cukup buat akun dengan awalan "admin", atau
 *   tambahkan namanya ke daftar TAMBAHAN di bawah.
 */
class HeroSliderController extends Controller
{
    /** Nama pengguna yang selalu diizinkan, di luar awalan "admin". */
    const TAMBAHAN = ['developer'];

    /** Awalan nama pengguna yang diizinkan. */
    const AWALAN = 'admin';

    /**
     * Apakah pengguna yang sedang login boleh mengelola hero?
     * Dipakai controller ini dan juga oleh menu di navbar, supaya
     * menunya tidak muncul untuk yang tidak berhak.
     *
     * @return bool
     */
    public static function bolehKelola()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $nama = strtolower((string) Yii::$app->user->identity->username);

        return in_array($nama, self::TAMBAHAN, true)
            || strncmp($nama, self::AWALAN, strlen(self::AWALAN)) === 0;
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return self::bolehKelola();
                        },
                    ],
                ],
                // Pengguna yang sudah login tetapi bukan pengelola
                // diberi pesan yang jelas, bukan sekadar diarahkan
                // ke halaman login yang membingungkan.
                'denyCallback' => function () {
                    if (Yii::$app->user->isGuest) {
                        return Yii::$app->response->redirect(['/site/login']);
                    }
                    throw new ForbiddenHttpException(
                        'Halaman pengelolaan banner hanya dapat diakses oleh akun developer dan admin.'
                    );
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'toggle' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Daftar seluruh banner, urut sesuai tampilnya di halaman depan.
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => HeroSlider::find()->orderBy(['urutan' => SORT_ASC, 'id' => SORT_ASC]),
            'pagination' => ['pageSize' => 30],
            'sort' => false,
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Tambah banner baru.
     */
    public function actionCreate()
    {
        $model = new HeroSlider();
        // Slide baru diletakkan paling belakang.
        $model->urutan = (int) HeroSlider::find()->max('urutan') + 1;
        $model->aktif = 1;

        if ($model->load(Yii::$app->request->post())) {
            $model->berkas = UploadedFile::getInstance($model, 'berkas');

            if ($model->validate()) {
                $nama = HeroImage::simpan($model->berkas);

                if ($nama === null) {
                    Yii::$app->session->setFlash('error',
                        'Gambar gagal diproses. Pastikan berkasnya benar-benar gambar JPG, PNG, atau WebP.');
                } else {
                    $model->gambar = $nama;
                    $model->berkas = null;

                    if ($model->save(false)) {
                        Yii::$app->session->setFlash('success',
                            'Banner berhasil ditambahkan dan ukurannya sudah disesuaikan otomatis.');
                        return $this->redirect(['index']);
                    }

                    // Simpan gagal: jangan tinggalkan berkas yatim.
                    HeroImage::hapus($nama);
                    Yii::$app->session->setFlash('error', 'Banner gagal disimpan ke database.');
                }
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Ubah banner. Gambar boleh tidak diganti.
     */
    public function actionUpdate($id)
    {
        $model = $this->cari($id);
        $gambarLama = $model->gambar;

        if ($model->load(Yii::$app->request->post())) {
            $model->berkas = UploadedFile::getInstance($model, 'berkas');

            if ($model->validate()) {
                $gambarBaru = null;

                if ($model->berkas !== null) {
                    $gambarBaru = HeroImage::simpan($model->berkas);
                    if ($gambarBaru === null) {
                        Yii::$app->session->setFlash('error',
                            'Gambar baru gagal diproses. Banner tidak diubah.');
                        return $this->render('update', ['model' => $model]);
                    }
                    $model->gambar = $gambarBaru;
                }

                $model->berkas = null;

                if ($model->save(false)) {
                    // Gambar lama dibuang hanya setelah yang baru benar
                    // benar tersimpan, supaya tidak ada slide kehilangan
                    // gambarnya bila terjadi kegagalan di tengah jalan.
                    if ($gambarBaru !== null && $gambarLama !== $gambarBaru) {
                        HeroImage::hapus($gambarLama);
                    }
                    Yii::$app->session->setFlash('success', 'Banner berhasil diperbarui.');
                    return $this->redirect(['index']);
                }

                if ($gambarBaru !== null) {
                    HeroImage::hapus($gambarBaru);
                    $model->gambar = $gambarLama;
                }
                Yii::$app->session->setFlash('error', 'Banner gagal disimpan.');
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Hapus banner beserta berkas gambarnya.
     */
    public function actionDelete($id)
    {
        $model = $this->cari($id);
        $gambar = $model->gambar;

        if ($model->delete()) {
            HeroImage::hapus($gambar);
            Yii::$app->session->setFlash('success', 'Banner dihapus.');
        } else {
            Yii::$app->session->setFlash('error', 'Banner gagal dihapus.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Tampilkan atau sembunyikan banner tanpa menghapusnya.
     */
    public function actionToggle($id)
    {
        $model = $this->cari($id);
        $model->aktif = $model->aktif ? 0 : 1;
        $model->save(false);

        Yii::$app->session->setFlash('success',
            $model->aktif ? 'Banner ditampilkan kembali.' : 'Banner disembunyikan dari halaman depan.');

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return HeroSlider
     * @throws NotFoundHttpException
     */
    private function cari($id)
    {
        $model = HeroSlider::findOne((int) $id);
        if ($model === null) {
            throw new NotFoundHttpException('Banner yang dimaksud tidak ditemukan.');
        }

        return $model;
    }
}
