<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dana_septic_individu".
 *
 * @property int $id
 * @property string|null $sumberDana
 */
class DanaSepticIndividu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dana_septic_individu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sumberDana'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sumberDana' => 'Sumber Dana',
        ];
    }
}
