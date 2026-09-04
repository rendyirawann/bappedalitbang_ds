<?php

namespace backend\models;

use Yii;
use backend\components\ActivityLogBehavior; // <-- Jangan lupa ini

/**
 * This is the model class for table "unduhan".
 *
 * @property int $id
 * @property string|null $namaFile
 * @property int|null $refbidang_id
 */
class Unduhan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unduhan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaFile'], 'string'],
            [['refbidang_id'], 'integer'],
        ];
    }

public function behaviors()
{
    return [
        [
            'class' => ActivityLogBehavior::class,
            'mainAttribute' => 'namaFile', // <-- Sesuaikan
        ],
    ];
}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'namaFile' => 'Nama File',
            'refbidang_id' => 'Refbidang ID',
        ];
    }

    public function getBidang()
    {
        return $this->hasOne(Bidang::class, ['id' => 'refbidang_id']);
    }
}
