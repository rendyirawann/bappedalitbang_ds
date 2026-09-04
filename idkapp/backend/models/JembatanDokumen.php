<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "jembatan_dokumen".
 *
 * @property int $id
 * @property int|null $kodeDataJembatan
 * @property string|null $namaFile
 * @property string|null $file
 */
class JembatanDokumen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jembatan_dokumen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kodeDataJembatan'], 'integer'],
            [['namaFile'], 'string'],
            [['file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kodeDataJembatan' => 'Kode Data Jembatan',
            'namaFile' => 'Nama File',
            'file' => 'File',
        ];
    }
}
