<?php

namespace backend\models;

use Yii;
use backend\components\ActivityLogBehavior; // <-- Jangan lupa ini

/**
 * This is the model class for table "berita_alt".
 *
 * @property int $id
 * @property int|null $berita_id
 * @property string|null $file
 *
 * @property Berita $berita
 */
class BeritaAlt extends \yii\db\ActiveRecord
{
    public $file_docs; // use a plural name
    public $file_doc; // use a singular name
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'berita_alt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['berita_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['berita_id'], 'exist', 'skipOnError' => true, 'targetClass' => Berita::class, 'targetAttribute' => ['berita_id' => 'id']],
            [['file_docs'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,JPG,heic,HEIC', 'maxFiles' => 5, 'maxSize' => 1024 * 1024 * 10], // Ukuran maksimum 10 MB per file
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

public function behaviors()
{
    return [
        [
            'class' => ActivityLogBehavior::class,
            'mainAttribute' => 'file', // <-- Sesuaikan
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
            'berita_id' => 'Berita ID',
            'file' => 'File',
        ];
    }

    /**
     * Gets query for [[Berita]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBerita()
    {
        return $this->hasOne(Berita::class, ['id' => 'berita_id']);
    }
}
