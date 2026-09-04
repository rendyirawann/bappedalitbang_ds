<?php

namespace backend\models;

use Yii;
use backend\components\ActivityLogBehavior; // <-- Jangan lupa ini

/**
 * This is the model class for table "profil".
 *
 * @property int $id
 * @property string|null $namaFile
 * @property string|null $file
 * @property string|null $tanggalUpload
 */
class Profil extends \yii\db\ActiveRecord
{
    public $file_doc;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaFile'], 'string'],
            [['tanggalUpload'], 'safe'],
            [['file'], 'string', 'max' => 255],
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
            'namaFile' => 'Nama File',
            'file' => 'File',
            'tanggalUpload' => 'Tanggal Upload',
        ];
    }
}
