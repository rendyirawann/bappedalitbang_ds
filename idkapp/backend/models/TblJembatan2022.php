<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_jembatan2022".
 *
 * @property int $id
 * @property int|null $no
 * @property string|null $namaPekerjaan
 * @property string|null $realisasi_meter
 * @property string|null $keterangan
 */
class TblJembatan2022 extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_jembatan2022';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no'], 'integer'],
            [['namaPekerjaan', 'keterangan'], 'string'],
            [['realisasi_meter'], 'string', 'max' => 255],
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
            'no' => 'No',
            'namaPekerjaan' => 'Nama Pekerjaan',
            'realisasi_meter' => 'Realisasi Meter',
            'keterangan' => 'Keterangan',
        ];
    }
}
