<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tahun_irigasi".
 *
 * @property int $id
 * @property int $tahun
 */
class TahunIrigasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tahun_irigasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun'], 'required'],
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
