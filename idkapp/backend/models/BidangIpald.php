<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bidang_ipald".
 *
 * @property int $id
 * @property string|null $namaBidang
 *
 * @property DataIpald[] $dataIpalds
 */
class BidangIpald extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bidang_ipald';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaBidang'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'namaBidang' => 'Nama Bidang',
        ];
    }

    /**
     * Gets query for [[DataIpalds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataIpalds()
    {
        return $this->hasMany(DataIpald::class, ['kodeBidang' => 'namaBidang']);
    }
}
