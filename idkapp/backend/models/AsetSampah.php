<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "aset_sampah".
 *
 * @property int $id
 * @property string|null $namaAset
 */
class AsetSampah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aset_sampah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaAset'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'namaAset' => 'Nama Aset',
        ];
    }
}
