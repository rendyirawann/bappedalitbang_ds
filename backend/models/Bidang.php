<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bidang".
 *
 * @property int $id
 * @property string $bidang
 *
 * @property Berita[] $beritas
 */
class Bidang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bidang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bidang'], 'required'],
            [['bidang'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bidang' => 'Bidang',
        ];
    }

    /**
     * Gets query for [[Beritas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBeritas()
    {
        return $this->hasMany(Berita::class, ['bidang_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'bidang_id']);
    }

    public function getUnduhan()
    {
        return $this->hasOne(Unduhan::class, ['refbidang_id' => 'id']);
    }
}
