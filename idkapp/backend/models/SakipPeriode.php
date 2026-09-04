<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sakip_periode".
 *
 * @property int $refperiode_id
 * @property int $periode
 * @property string|null $periode_isaktif
 */
class SakipPeriode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sakip_periode';
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['periode'], 'required'],
            [['periode'], 'integer'],
            [['periode_isaktif'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'refperiode_id' => 'Refperiode ID',
            'periode' => 'Periode',
            'periode_isaktif' => 'Periode Isaktif',
        ];
    }

    public static function getDb()
    {
        return Yii::$app->get('db1');
    }
}
