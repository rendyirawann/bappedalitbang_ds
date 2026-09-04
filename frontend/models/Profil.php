<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "profil".
 *
 * @property int $id
 * @property string|null $namaFile
 * @property string|null $file
 * @property string|null $tanggalUpload
 */
class Profil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaFile'], 'string'],
            [['tanggalUpload'], 'safe'],
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
            'namaFile' => 'Nama File',
            'file' => 'File',
            'tanggalUpload' => 'Tanggal Upload',
        ];
    }
}
