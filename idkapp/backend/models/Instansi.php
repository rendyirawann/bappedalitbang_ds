<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "instansi".
 *
 * @property int $id
 * @property string|null $instansi
 */
class Instansi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'instansi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['instansi'], 'string'],
            [['kode_skpd'], 'safe'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_skpd' => 'Kode SKPD',
            'instansi' => 'Instansi',
        ];
    }

    public function getUsers()
    {
        return $this->hasMany(User::class, ['instansi_id' => 'id']);
    }
}
