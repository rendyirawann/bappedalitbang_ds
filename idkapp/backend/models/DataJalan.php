<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_jalan".
 *
 * @property int $id
 * @property int|null $kodeKecamatan
 * @property string|null $namaJalan
 *
 */
class DataJalan extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_jalan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaJalan'], 'string', 'max' => 255],
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
            'namaJalan' => 'Nama Jalan',
        ];
    }

    /**
     * Gets query for [[KodeKecamatan0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeKecamatan0()
    {
        return $this->hasOne(DataKecamatan::class, ['id' => 'kodeKecamatan']);
    }
}
