<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "standar_pelayanan".
 *
 * @property int $id
 * @property string $file
 * @property string $namaFile
 * @property int $tahun
 */
class StandarPelayanan extends \yii\db\ActiveRecord
{
    public $file_docs; // upload batch (banyak file sekaligus)
    public $file_doc;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'standar_pelayanan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun'], 'required'],
            [['tahun'], 'integer', 'min' => 2000, 'max' => 2100],
            [['file', 'namaFile'], 'string', 'max' => 255],
            [
                ['file_docs'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
                'checkExtensionByMimeType' => true,
                'mimeTypes' => ['application/pdf', 'image/jpeg', 'image/png'],
                'maxFiles' => 10,
                'maxSize' => 1024 * 1024 * 10,
                'tooBig' => 'Ukuran file tidak boleh lebih dari 10MB.',
                'wrongExtension' => 'Hanya file dengan format {extensions} yang diizinkan.',
                'wrongMimeType' => 'Tipe file tidak valid.',
            ],
            [
                ['file_doc'],
                'file',
                'skipOnEmpty' => true,
                // Daftar ekstensi yang diizinkan (tetap penting sebagai filter awal)
                'extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
                // Periksa tipe file asli menggunakan MIME type, ini LEBIH AMAN!
                'checkExtensionByMimeType' => true,
                'mimeTypes' => ['application/pdf', 'image/jpeg', 'image/png'],
                // Ukuran maksimum 10 MB
                'maxSize' => 1024 * 1024 * 10,
                'tooBig' => 'Ukuran file tidak boleh lebih dari 10MB.',
                'wrongExtension' => 'Hanya file dengan format {extensions} yang diizinkan.',
                'wrongMimeType' => 'Tipe file tidak valid.',
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
            'namaFile' => 'Nama Dokumen',
            'tahun' => 'Tahun',
            'file_doc' => 'File Dokumen',
        ];
    }

    /**
     * Apakah file dokumen ini berupa PDF.
     * @return bool
     */
    public function getIsPdf()
    {
        return strtolower(pathinfo((string) $this->file, PATHINFO_EXTENSION)) === 'pdf';
    }
}
