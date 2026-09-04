<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tahapan".
 *
 * @property int $id
 * @property string $judul_tahapan
 * @property int $tahun
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property TahapanItem[] $tahapanItems
 */
class Tahapan extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tahapan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['judul_tahapan', 'tahun'], 'required'],
            [['tahun', 'created_at', 'updated_at'], 'integer'],
            [['judul_tahapan'], 'string', 'max' => 255],
        ];
    }

    public function getTahapanItems()
    {
        return $this->hasMany(TahapanItem::className(), ['tahapan_id' => 'id'])->orderBy(['urutan' => SORT_ASC]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'judul_tahapan' => 'Judul Tahapan',
            'tahun' => 'Tahun',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
