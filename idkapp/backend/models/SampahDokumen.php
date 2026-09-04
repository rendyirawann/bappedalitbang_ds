<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sampah_dokumen".
 *
 * @property int $id
 * @property int|null $kodeDataSampah
 * @property string|null $namaFile
 * @property string|null $file
 */
class SampahDokumen extends \yii\db\ActiveRecord
{
    public $file_docs; // use a plural name
    public $file_doc; // use a singular name
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sampah_dokumen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kodeDataSampah'], 'integer'],
            [['namaFile'], 'string'],
            [['file'], 'string', 'max' => 255],
            [['file_docs'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,JPG,heic,HEIC', 'maxFiles' => 5, 'maxSize' => 1024 * 1024 * 10], // Ukuran maksimum 10 MB per file
            [['file_doc'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,JPG,heic,HEIC', 'maxSize' => 1024 * 1024 * 10], // Ukuran maksimum 10 MB per file
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kodeDataSampah' => 'Kode Data Sampah',
            'namaFile' => 'Nama File',
            'file' => 'File',
        ];
    }
}
