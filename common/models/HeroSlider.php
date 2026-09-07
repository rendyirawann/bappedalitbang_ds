<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Banner hero pada halaman depan.
 *
 * Diletakkan di common karena dipakai dua sisi: backend untuk
 * pengelolaan, frontend untuk menampilkan.
 *
 * @property int         $id
 * @property string      $gambar       nama berkas di web/uploads/hero/
 * @property string|null $judul        teks besar di atas gambar
 * @property string|null $subjudul     teks kecil di bawah judul
 * @property string|null $teks_tombol  tulisan pada tombol, mis. "Explore"
 * @property string|null $url_tombol   alamat tujuan tombol
 * @property int         $urutan       makin kecil makin awal tampil
 * @property int         $aktif        1 tampil, 0 disembunyikan
 * @property int|null    $created_at
 * @property int|null    $updated_at
 */
class HeroSlider extends ActiveRecord
{
    /**
     * Berkas gambar yang diunggah. Bukan kolom tabel - hanya wadah
     * sementara sebelum diproses HeroImage.
     *
     * @var \yii\web\UploadedFile|null
     */
    public $berkas;

    public static function tableName()
    {
        return 'hero_slider';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['judul', 'teks_tombol', 'url_tombol'], 'trim'],
            [['subjudul'], 'trim'],

            [['judul'], 'string', 'max' => 255],
            [['subjudul'], 'string'],
            [['teks_tombol'], 'string', 'max' => 100],
            [['url_tombol'], 'string', 'max' => 255],
            [['url_tombol'], 'url', 'defaultScheme' => 'https',
                'message' => 'Alamat tautan tidak valid. Contoh: https://esakipsimonalisa.deliserdangkab.go.id/'],

            [['urutan'], 'integer', 'min' => 0, 'max' => 9999],
            [['urutan'], 'default', 'value' => 0],

            [['aktif'], 'boolean'],
            [['aktif'], 'default', 'value' => 1],

            [['gambar'], 'string', 'max' => 255],

            // Gambar wajib saat menambah slide baru; saat mengubah,
            // boleh dikosongkan bila gambarnya tidak diganti.
            [['berkas'], 'required', 'when' => function ($model) {
                return $model->isNewRecord && empty($model->gambar);
            }, 'whenClient' => false, 'message' => 'Gambar wajib diunggah.'],

            [['berkas'], 'file',
                'skipOnEmpty'              => true,
                'extensions'               => ['jpg', 'jpeg', 'png', 'webp'],
                'checkExtensionByMimeType' => true,
                'mimeTypes'                => ['image/jpeg', 'image/png', 'image/webp'],
                'maxSize'                  => 1024 * 1024 * 20,
                'tooBig'                   => 'Ukuran gambar tidak boleh lebih dari 20 MB.',
                'wrongExtension'           => 'Gambar harus berformat {extensions}.',
                'wrongMimeType'            => 'Berkas yang diunggah bukan gambar yang sah.',
            ],

            // Tombol hanya berarti bila keduanya diisi.
            [['url_tombol'], 'required',
                'when' => function ($model) { return !empty($model->teks_tombol); },
                'whenClient' => false,
                'message' => 'Isi juga alamat tautan bila tombol diberi tulisan.'],
            [['teks_tombol'], 'required',
                'when' => function ($model) { return !empty($model->url_tombol); },
                'whenClient' => false,
                'message' => 'Isi juga tulisan tombol bila alamat tautan diisi.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'berkas'      => 'Gambar Banner',
            'gambar'      => 'Gambar',
            'judul'       => 'Judul',
            'subjudul'    => 'Subjudul',
            'teks_tombol' => 'Tulisan Tombol',
            'url_tombol'  => 'Alamat Tautan Tombol',
            'urutan'      => 'Urutan Tampil',
            'aktif'       => 'Ditampilkan',
            'created_at'  => 'Dibuat',
            'updated_at'  => 'Diubah',
        ];
    }

    /**
     * Slide yang tampil di halaman depan, sudah urut.
     *
     * @return HeroSlider[]
     */
    public static function yangTampil()
    {
        return static::find()
            ->where(['aktif' => 1])
            ->orderBy(['urutan' => SORT_ASC, 'id' => SORT_ASC])
            ->all();
    }

    /**
     * Alamat gambar untuk ditampilkan di halaman depan.
     *
     * @return string
     */
    public function urlGambarFrontend()
    {
        return Url::base(true) . '/uploads/hero/' . rawurlencode($this->gambar);
    }

    /**
     * Alamat gambar untuk pratinjau di halaman pengelolaan backend.
     *
     * @return string
     */
    public function urlGambarBackend()
    {
        return Url::base(true) . '/uploads/hero/' . rawurlencode($this->gambar);
    }

    /**
     * Apakah slide ini punya lapisan teks di atas gambarnya?
     * Slide tanpa teks ditampilkan sebagai gambar polos.
     *
     * @return bool
     */
    public function punyaTeks()
    {
        return $this->judul !== null && $this->judul !== '';
    }

    /**
     * Apakah slide ini punya tombol?
     *
     * @return bool
     */
    public function punyaTombol()
    {
        return !empty($this->teks_tombol) && !empty($this->url_tombol);
    }
}
