<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ipald_dokumen".
 *
 * @property int $id
 * @property int|null $kodeDataIpald
 * @property string|null $namaFile
 * @property string|null $file
 *
 * @property DataIpald $kodeDataIpald0
 */
class IpaldDokumen extends \yii\db\ActiveRecord
{
    public $file_docs; // use a plural name
    public $file_doc; // use a singular name
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ipald_dokumen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kodeDataIpald'], 'integer'],
            [['namaFile'], 'string'],
            [['file'], 'string', 'max' => 255],
            [['kodeDataIpald'], 'exist', 'skipOnError' => true, 'targetClass' => DataIpald::class, 'targetAttribute' => ['kodeDataIpald' => 'id']],
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
            'kodeDataIpald' => 'Kode Data Ipald',
            'namaFile' => 'Nama File',
            'file' => 'File',
        ];
    }

    /**
     * Gets query for [[KodeDataIpald0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeDataIpald0()
    {
        return $this->hasOne(DataIpald::class, ['id' => 'kodeDataIpald']);
    }
}
