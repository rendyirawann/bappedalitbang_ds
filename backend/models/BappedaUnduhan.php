<?php

namespace backend\models;

use Yii;
use backend\components\ActivityLogBehavior; // <-- Jangan lupa ini


/**
 * This is the model class for table "bappeda_unduhan".
 *
 * @property int $refunduhan_id
 * @property int|null $refbidang_id
 * @property string|null $file
 * @property string|null $nama_file
 */
class BappedaUnduhan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bappeda_unduhan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['refbidang_id'], 'integer'],
            [['nama_file'], 'string'],
            [['file'], 'string', 'max' => 255],
        ];
    }

public function behaviors()
{
    return [
        [
            'class' => ActivityLogBehavior::class,
            'mainAttribute' => 'file', // <-- Sesuaikan
        ],
    ];
}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'refunduhan_id' => 'Refunduhan ID',
            'refbidang_id' => 'Refbidang ID',
            'file' => 'File',
            'nama_file' => 'Nama File',
        ];
    }
}
