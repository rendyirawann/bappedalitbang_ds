<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "keterangan_jembatan".
 *
 * @property int $id
 * @property string $namaKeterangan
 */
class KeteranganJembatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keterangan_jembatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaKeterangan'], 'required'],
            [['namaKeterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'namaKeterangan' => 'Nama Keterangan',
        ];
    }
}
