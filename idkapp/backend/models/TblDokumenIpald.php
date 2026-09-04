<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_dokumen_ipald".
 *
 * @property int $id
 * @property int|null $ipald_id
 * @property string $file
 *
 * @property TblIpald $ipald
 */
class TblDokumenIpald extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_dokumen_ipald';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ipald_id'], 'integer'],
            [['file'], 'required'],
            [['file'], 'string', 'max' => 255],
            [['ipald_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblIpald::class, 'targetAttribute' => ['ipald_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ipald_id' => 'Ipald ID',
            'file' => 'File',
        ];
    }

    /**
     * Gets query for [[Ipald]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIpald()
    {
        return $this->hasOne(TblIpald::class, ['id' => 'ipald_id']);
    }
}
