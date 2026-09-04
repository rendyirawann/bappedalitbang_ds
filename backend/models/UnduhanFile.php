<?php

namespace backend\models;

use Yii;
use backend\components\ActivityLogBehavior; // <-- Jangan lupa ini

/**
 * This is the model class for table "unduhan_file".
 *
 * @property int $id
 * @property int|null $refunduhan_id
 * @property string|null $file
 * @property string|null $tanggalUpload
 */
class UnduhanFile extends \yii\db\ActiveRecord
{

    public $file_docs; // use a plural name
    public $file_doc; // use a singular name
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unduhan_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        // Daftar ekstensi yang kita izinkan
        $allowedExtensions = [
            // Gambar
            'jpg', 'jpeg', 'png', 'heic', 
            // Dokumen
            'pdf', 
            // Microsoft Word
            'doc', 'docx', 
            // Microsoft Excel
            'xls', 'xlsx', 
            // Microsoft PowerPoint
            'ppt', 'pptx',
        ];

        // Daftar MIME types yang sesuai dengan ekstensi di atas
        $allowedMimeTypes = [
            // Gambar
            'image/jpeg', 'image/png', 'image/heic',
            // Dokumen
            'application/pdf',
            // Microsoft Word
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            // Microsoft Excel
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            // Microsoft PowerPoint
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ];

        return [
            [['refunduhan_id'], 'integer'],
            [['tanggalUpload'], 'safe'],
            [['file'], 'string', 'max' => 255],

            // Aturan untuk UPLOAD BANYAK FILE
            [
                ['file_docs'], 
                'file', 
                'skipOnEmpty' => true, 
                'extensions' => $allowedExtensions,
                'checkExtensionByMimeType' => true, // <-- KEAMANAN TAMBAHAN
                'mimeTypes' => $allowedMimeTypes,
                'maxFiles' => 5, // Batas jumlah file
                'maxSize' => 1024 * 1024 * 10, // 10 MB
                'tooBig' => 'Ukuran file tidak boleh melebihi 10MB.',
            ],

            // Aturan untuk UPLOAD SATU FILE
            [
                ['file_doc'], 
                'file', 
                'skipOnEmpty' => true, 
                'extensions' => $allowedExtensions,
                'checkExtensionByMimeType' => true, // <-- KEAMANAN TAMBAHAN
                'mimeTypes' => $allowedMimeTypes,
                'maxSize' => 1024 * 1024 * 10, // 10 MB
                'tooBig' => 'Ukuran file tidak boleh melebihi 10MB.',
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'refunduhan_id' => 'Refunduhan ID',
            'file' => 'File',
            'tanggalUpload' => 'Tanggal Upload',
        ];
    }

    public function getUnduhan()
    {
        return $this->hasOne(Unduhan::class, ['id' => 'refunduhan_id']);
    }
}
