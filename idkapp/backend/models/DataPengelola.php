<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_pengelola".
 *
 * @property int $id
 * @property string|null $namaPengelola
 *
 * @property DataIpald[] $dataIpalds
 */
class DataPengelola extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_pengelola';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaPengelola'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'namaPengelola' => 'Nama Pengelola',
        ];
    }

    /**
     * Gets query for [[DataIpalds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataIpalds()
    {
        return $this->hasMany(DataIpald::class, ['kodePengelola' => 'namaPengelola']);
    }
}
