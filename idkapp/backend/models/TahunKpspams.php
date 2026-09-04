<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tahun_kpspams".
 *
 * @property int $id
 * @property int $tahun
 */
class TahunKpspams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tahun_kpspams';
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
