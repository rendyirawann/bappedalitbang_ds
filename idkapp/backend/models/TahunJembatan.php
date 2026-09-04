<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tahun_jembatan".
 *
 * @property int $id
 * @property int|null $tahun
 */
class TahunJembatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tahun_jembatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahun' => 'Tahun',
        ];
    }
}
