<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "aset_ipald".
 *
 * @property int $id
 * @property string|null $namaAset
 */
class AsetIpald extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aset_ipald';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaAset'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'namaAset' => 'Nama Aset',
        ];
    }

        /**
     * Gets query for [[DataIpalds0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataIpalds0()
    {
        return $this->hasMany(DataIpald::class, ['kodeAset' => 'namaAset']);
    }
}
