<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "berita_alt".
 *
 * @property int $id
 * @property int|null $berita_id
 * @property string|null $file
 *
 * @property Berita $berita
 */
class BeritaAlt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'berita_alt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['berita_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['berita_id'], 'exist', 'skipOnError' => true, 'targetClass' => Berita::class, 'targetAttribute' => ['berita_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'berita_id' => 'Berita ID',
            'file' => 'File',
        ];
    }

    /**
     * Gets query for [[Berita]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBerita()
    {
        return $this->hasOne(Berita::class, ['id' => 'berita_id']);
    }
}
