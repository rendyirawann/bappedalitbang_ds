<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tahapan".
 *
 * @property int $id
 * @property string $judul_tahapan
 * @property string $nama_tahapan
 * @property int|null $urutan
 * @property string|null $icon_gambar
 * @property string|null $tanggal
 * @property string|null $dokumen
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Tahapan extends \yii\db\ActiveRecord
{
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
            [['judul_tahapan', 'nama_tahapan'], 'required'],
            [['urutan', 'created_at', 'updated_at'], 'integer'],
            [['tanggal'], 'safe'],
            [['judul_tahapan', 'nama_tahapan', 'icon_gambar', 'dokumen'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'judul_tahapan' => 'Judul Tahapan',
            'nama_tahapan' => 'Nama Tahapan',
            'urutan' => 'Urutan',
            'icon_gambar' => 'Icon Gambar',
            'tanggal' => 'Tanggal',
            'dokumen' => 'Dokumen',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
