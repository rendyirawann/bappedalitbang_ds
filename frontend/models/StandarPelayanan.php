<?php

namespace frontend\models;

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
            [['namaFile', 'tahun'], 'required'],
            [['tahun'], 'integer'],
            [['file', 'namaFile'], 'string', 'max' => 255],
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
