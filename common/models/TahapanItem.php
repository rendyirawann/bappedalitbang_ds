<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tahapan_item".
 *
 * @property int $id
 * @property int $tahapan_id
 * @property string $nama_tahapan
 * @property int|null $urutan
 * @property string|null $icon_gambar
 * @property string|null $tanggal
 * @property string|null $dokumen
 *
 * @property Tahapan $tahapan
 */
class TahapanItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tahapan_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahapan_id', 'nama_tahapan'], 'required'],
            [['tahapan_id', 'urutan'], 'integer'],
            [['nama_tahapan', 'icon_gambar', 'tanggal', 'dokumen'], 'string', 'max' => 255],
            [['tahapan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tahapan::class, 'targetAttribute' => ['tahapan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahapan_id' => 'Tahapan ID',
            'nama_tahapan' => 'Nama Tahapan',
            'urutan' => 'Urutan',
            'icon_gambar' => 'Icon Gambar',
            'tanggal' => 'Tanggal',
            'dokumen' => 'Dokumen',
        ];
    }

    /**
     * Gets query for [[Tahapan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTahapan()
    {
        return $this->hasOne(Tahapan::class, ['id' => 'tahapan_id']);
    }
}
