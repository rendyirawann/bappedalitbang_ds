<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_kecamatan".
 *
 * @property int $id
 * @property string|null $namaKecamatan
 *
 * @property DataJalan[] $dataJalans
 */
class DataKecamatan extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_kecamatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaKecamatan'], 'string'],
            [['kode'], 'integer'],
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
            'namaKecamatan' => 'Nama Kecamatan',
            'kode' => 'Kode Kecamatan',
        ];
    }

    /**
     * Gets query for [[DataJalans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataJalans()
    {
        return $this->hasMany(DataJalan::class, ['kodeKecamatan' => 'id']);
    }
}
