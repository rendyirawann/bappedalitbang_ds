<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_desa".
 *
 * @property int $id
 * @property string|null $namaDesa
 */
class DataDesa extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_desa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaDesa'], 'string'],
            [['kode', 'idKecamatan'], 'integer'],
            [['file'], 'file', 'skipOnEmpty' => true, 'maxSize' => 1024 * 1024 * 10], // Ukuran maksimum 10 MB per file
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'namaDesa' => 'Nama Desa',
            'kode' => 'Kode Desa',
            'idKecamatan' => 'Kode Kecamatan',
        ];
    }

    public function getKecamatan()
    {
        return $this->hasOne(DataKecamatan::class, ['kode' => 'idKecamatan']);
    }
    
}
