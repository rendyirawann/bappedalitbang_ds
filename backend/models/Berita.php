<?php

namespace backend\models;

use Yii;
use backend\components\ActivityLogBehavior;

/**
 * This is the model class for table "berita".
 *
 * @property int $id
 * @property string|null $file
 * @property string $judulBerita
 * @property string $isiBerita
 * @property int|null $bidang_id
 * @property string|null $keterangan
 * @property int|null $status
 *
 * @property BeritaAlt[] $beritaAlts
 * @property Bidang $bidang
 */
class Berita extends \yii\db\ActiveRecord
{
    public $file_doc;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'berita';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['judulBerita', 'isiBerita'], 'required'],
            [['tgl_berita'], 'safe'],
            [['judulBerita', 'isiBerita', 'keterangan'], 'string'],
            [['bidang_id', 'status'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['bidang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bidang::class, 'targetAttribute' => ['bidang_id' => 'id']],
           [
    ['file_doc'], 
    'file', 
    'skipOnEmpty' => true, 
    // Daftar ekstensi yang diizinkan (tetap penting sebagai filter awal)
    'extensions' => ['jpg', 'jpeg', 'png', 'heic'],
    // Periksa tipe file asli menggunakan MIME type, ini LEBIH AMAN!
    'checkExtensionByMimeType' => true,
    // Daftar MIME type yang sesuai dengan ekstensi di atas
    'mimeTypes' => ['image/jpeg', 'image/png', 'image/heic'], 
    // Ukuran maksimum 10 MB
    'maxSize' => 1024 * 1024 * 10, 
    // Pesan error kustom jika diinginkan
    'tooBig' => 'Ukuran file tidak boleh lebih dari 10MB.', 
    'wrongExtension' => 'Hanya file dengan format {extensions} yang diizinkan.',
    'wrongMimeType' => 'Tipe file tidak valid.'
], // Ukuran maksimum 10 MB per file
        ];
    }

// 2. Taruh ini di dalam class Berita (sebelum atau sesudah rules)
public function behaviors()
{
    return [
        [
            'class' => ActivityLogBehavior::class,
            'mainAttribute' => 'judulBerita', // Log akan catat judul beritanya
        ],
    ];
}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File',
            'judulBerita' => 'Judul Berita',
            'isiBerita' => 'Isi Berita',
            'bidang_id' => 'Bidang ID',
            'tgl_berita' => 'Tanggal Berita',
            'keterangan' => 'Keterangan',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[BeritaAlts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBeritaAlts()
    {
        return $this->hasMany(BeritaAlt::class, ['berita_id' => 'id']);
    }

    /**
     * Gets query for [[Bidang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBidang()
    {
        return $this->hasOne(Bidang::class, ['id' => 'bidang_id']);
    }

public function getStatusText()
{
    $statusText = [
        0 => 'Review',
        1 => 'Publish',
        2 => 'Ditolak',
    ];

    return $statusText[$this->status] ?? 'Unknown';
}

}
