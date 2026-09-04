<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use backend\components\ActivityLogBehavior; // <-- Jangan lupa ini

/**
 * This is the model class for table "struktur".
 *
 * @property int $id
 * @property string|null $file
 * @property string|null $namaFile
 */
class Struktur extends \yii\db\ActiveRecord
{
    public $file_doc;

    public static function tableName()
    {
        return 'struktur';
    }

    public function rules()
    {
        return [
            // 1. Sanitasi: Hapus semua tag HTML/Script dari namaFile
            [['namaFile'], 'filter', 'filter' => 'strip_tags'],
            [['namaFile'], 'string'],
            
            // 2. Validasi panjang string file path
            [['file'], 'string', 'max' => 255],

            // 3. Validasi File Upload (Dirapikan)
            [['file_doc'], 'file', 
                'skipOnEmpty' => true, 
                'extensions' => ['jpg', 'jpeg', 'png', 'heic'],
                'checkExtensionByMimeType' => true,
                'mimeTypes' => ['image/jpeg', 'image/png', 'image/heic'], 
                'maxSize' => 1024 * 1024 * 10, // 10MB
                'tooBig' => 'Ukuran file tidak boleh lebih dari 10MB.', 
                'wrongExtension' => 'Hanya file dengan format {extensions} yang diizinkan.',
                'wrongMimeType' => 'Tipe file tidak valid.'
            ],
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

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File',
            'namaFile' => 'Nama Struktur',
            'file_doc' => 'Upload Struktur',
        ];
    }

    /**
     * PROTEKSI 1 ROW SAJA
     * Fungsi ini akan berjalan sebelum data disimpan (Create/Update).
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Jika ini adalah Insert (data baru) DAN sudah ada data di database
        if ($insert && self::find()->count() > 0) {
            Yii::$app->session->setFlash('error', 'Hanya diperbolehkan satu data Struktur. Silahkan edit data yang ada.');
            return false; // Batalkan penyimpanan
        }

        return true;
    }
}