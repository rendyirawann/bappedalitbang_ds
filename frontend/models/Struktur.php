<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "struktur".
 *
 * @property int $id
 * @property string|null $file
 * @property string|null $namaFile
 */
class Struktur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'struktur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaFile'], 'string'],
            [['file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File',
            'namaFile' => 'Nama File',
        ];
    }
}
