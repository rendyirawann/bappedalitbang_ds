<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bidang_sampah".
 *
 * @property int $id
 * @property string|null $namaBidang
 */
class BidangSampah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bidang_sampah';
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
}
