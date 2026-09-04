<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_dokumen_sampah".
 *
 * @property int $id
 * @property int|null $sampah_id
 * @property string|null $file
 *
 * @property TblSampah $sampah
 */
class TblDokumenSampah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_dokumen_sampah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sampah_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['sampah_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblSampah::class, 'targetAttribute' => ['sampah_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sampah_id' => 'Sampah ID',
            'file' => 'File',
        ];
    }

    /**
     * Gets query for [[Sampah]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSampah()
    {
        return $this->hasOne(TblSampah::class, ['id' => 'sampah_id']);
    }
}
