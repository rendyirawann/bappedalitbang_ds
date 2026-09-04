<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dana_sampah".
 *
 * @property int $id
 * @property string|null $sumberDana
 */
class DanaSampah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dana_sampah';
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
