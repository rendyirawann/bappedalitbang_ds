<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use backend\models\Berita;
use backend\models\Galeri;
use backend\models\Bidang;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use backend\models\ResendVerificationEmailForm;
use backend\models\VerifyEmailForm;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
// use common\models\User;
use backend\models\User;
use yii\db\Expression;
use backend\models\VerifyOtpForm;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;
use yii\data\ActiveDataProvider;
use backend\models\LogActivity;
use DateTime;
use yii\helpers\{Html, Url};

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['change-profile'],
                        'allow' => true,
                        'roles' => ['@'], // Hanya pengguna yang sudah login yang diperbolehkan
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {   
        // Mengambil assignment user saat ini
        $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());

        // Cek apakah user memiliki assignment 'kabid'
        if (isset($assignments['kabid'])) {
            // Mengambil bidang_id user saat ini
            $userBidangId = Yii::$app->user->identity->bidang_id;
            $countBeritaPerencanaan = Berita::find()
            ->where(['bidang_id' => $userBidangId])
            ->count();
            // Mengambil jumlah berita yang perlu di-review (status = 0) yang sesuai dengan bidang_id user saat ini
            $countBeritaReview = Berita::find()
                ->where(['status' => 0, 'bidang_id' => $userBidangId])
                ->count();
            $countBeritaPublish = Berita::find()
                ->where(['status' => 1, 'bidang_id' => $userBidangId])
                ->count();        
        } else {
            // Mengambil jumlah berita yang perlu di-review (status = 0)
            $countBeritaPerencanaan = Berita::find()->count();
            $countBeritaReview = Berita::find()->where(['status' => 0])->count();
                // Mengambil jumlah berita yang dipublikasikan (status = 1)
        $countBeritaPublish = Berita::find()->where(['status' => 1])->count();
        }


        // Mengambil jumlah semua galeri
        $countGaleri = Galeri::find()->count();

        // Ambil data bidang dan berita terkait
        $bidangData = Bidang::find()->all();
        $bidangLabels = [];
        $bidangCounts = [];

        // Membuat array singkatan bidang
        $bidangSingkatan = [
            'PPEPD' => 'PPEPD',
            'Infrastruktur dan Kewilayahan' => 'IDK',
            'Penelitian dan Pengembangan' => 'Litbang',
            'Bagian Umum' => 'Umum',
            'Program' => 'Program',
            'Keuangan' => 'Keuangan',
            'Ekonomi dan SDA' => 'Ekonomi',
            'Pemerintahan dan Pembangunan Manusia' => 'PPM'
        ];

        foreach ($bidangData as $bidang) {
            $countBerita = Berita::find()->where(['bidang_id' => $bidang->id])->count();
            if ($countBerita > 0) { // Hanya masukkan bidang yang memiliki berita
                $bidangLabels[] = $bidangSingkatan[$bidang->bidang];
                $bidangCounts[] = $countBerita;
            }
        }

$recentLogs = LogActivity::find()
        ->orderBy(['created_at' => SORT_DESC])
        ->limit(10)
        ->all();

        return $this->render('index', [
            'countBeritaPerencanaan' => $countBeritaPerencanaan,
            'countBeritaReview' => $countBeritaReview,
            'countBeritaPublish' => $countBeritaPublish,
            'countGaleri' => $countGaleri,
            'bidangLabels' => $bidangLabels,
            'bidangCounts' => $bidangCounts,
'recentLogs' => $recentLogs, // <-- KIRIM LOG KE VIEW
        ]);
    }


    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
    
        $this->layout = 'blank';
    
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                Yii::$app->session->setFlash('success', 'Anda Berhasil Login');
                return $this->goBack();
            } else {
                Yii::$app->session->setFlash('error', 'Username atau password salah');
            }
        }
    
        $model->password = '';
    
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('success', 'Anda Telah Logout');

        return $this->goHome();
    }

    public function actionChangeProfile($id)
    {
        // Check if the requested ID matches the currently logged-in user
        if ($id != Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException('You are not allowed to perform this action.');
        }
    
        $model = User::findOne($id);
    
        // Check if the model is found
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('The requested user does not exist.');
        }
    
        // Store the current hashed password for comparison
        $oldPasswordHash = $model->password_hash;
    
        // Handle the form submission
        if ($model->load(Yii::$app->request->post())) {
            // Check if the password has been changed
            if (!empty($model->password_hash) && $model->password_hash !== $oldPasswordHash) {
                // Hash the new password
                $model->setPassword($model->password_hash);
            } else {
                // If password remains empty or unchanged, restore the previous hash
                $model->password_hash = $oldPasswordHash;
            }
    
            // Save the model
            if ($model->save()) {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('success', 'Password Telah Diganti Harap Login Kembali!');
                return $this->redirect(['site/login']);
                // return $this->refresh(); // Redirect to the current page to avoid reposting the form
            }
        }
    
        return $this->render('change-profile', [
            'model' => $model,
        ]);
    }
}
