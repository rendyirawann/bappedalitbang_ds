<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "status_aset".
 *
 * @property int $id
 * @property string|null $namaStatus
 *
 * @property DataIpald[] $dataIpalds
 * @property DataIpald[] $dataIpalds0
 */
class StatusAset extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status_aset';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaStatus'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'namaStatus' => 'Nama Status',
        ];
    }


    /**
     * Gets query for [[DataIpalds0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataIpalds0()
    {
        return $this->hasMany(DataIpald::class, ['kodeStatus' => 'namaStatus']);
    }
}
