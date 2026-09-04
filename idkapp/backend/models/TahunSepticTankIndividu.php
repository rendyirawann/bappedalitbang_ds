<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tahun_septic_tank_individu".
 *
 * @property int $id
 * @property int|null $tahun
 */
class TahunSepticTankIndividu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tahun_septic_tank_individu';
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
