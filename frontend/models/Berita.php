<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "berita".
 *
 * @property int $id
 * @property string|null $file
 * @property string $judulBerita
 * @property string $isiBerita
 * @property int|null $bidang_id
 * @property string|null $tgl_berita
 * @property string|null $keterangan
 * @property int|null $status
 *
 * @property BeritaAlt[] $beritaAlts
 * @property Bidang $bidang
 */
class Berita extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'berita';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['judulBerita', 'isiBerita'], 'required'],
            [['judulBerita', 'isiBerita', 'keterangan'], 'string'],
            [['bidang_id', 'status'], 'integer'],
            [['tgl_berita'], 'safe'],
            [['file'], 'string', 'max' => 255],
            [['bidang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bidang::class, 'targetAttribute' => ['bidang_id' => 'id']],
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
            'judulBerita' => 'Judul Berita',
            'isiBerita' => 'Isi Berita',
            'bidang_id' => 'Bidang ID',
            'tgl_berita' => 'Tgl Berita',
            'keterangan' => 'Keterangan',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[BeritaAlts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBeritaAlts()
    {
        return $this->hasMany(BeritaAlt::class, ['berita_id' => 'id']);
    }

    /**
     * Gets query for [[Bidang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBidang()
    {
        return $this->hasOne(Bidang::class, ['id' => 'bidang_id']);
    }
}
