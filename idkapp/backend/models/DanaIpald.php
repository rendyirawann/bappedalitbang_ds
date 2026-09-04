<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dana_ipald".
 *
 * @property int $id
 * @property string|null $sumberDana
 *
 * @property DataIpald[] $dataIpalds
 */
class DanaIpald extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dana_ipald';
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

    /**
     * Gets query for [[DataIpalds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataIpalds()
    {
        return $this->hasMany(DataIpald::class, ['kodeDana' => 'sumberDana']);
    }
}
