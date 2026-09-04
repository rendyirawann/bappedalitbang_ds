<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "irigasi_bangunan".
 *
 * @property int $id
 * @property string|null $nomeklatur
 * @property string|null $kodeDesa
 * @property string|null $luasIrigasi
 * @property string|null $bgnUtamaStatus
 * @property string|null $bgnUtamaKondisi
 * @property string|null $bgnPengaturPengukurStatus
 * @property string|null $bgnPengaturPengukurKondisi
 * @property string|null $bgnPembawaStatus
 * @property string|null $bgnPembawaKondisi
 * @property string|null $bgnLindungStatus
 * @property string|null $bgnLindungKondisi
 * @property string|null $bgnPelengkapStatus
 * @property string|null $bgnPelengkapKondisi
 * @property string|null $saranaStatus
 * @property string|null $saranaKondisi
 * @property string|null $rataStatus
 * @property string|null $rataKondisi
 * @property string|null $keterangan
 * @property int|null $kodeTahun
 */
class IrigasiBangunan extends \yii\db\ActiveRecord
{
    public $pembagiRataKondisi;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'irigasi_bangunan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bgnUtamaStatus', 'bgnPengaturPengukurStatus', 'bgnPembawaStatus', 'bgnLindungStatus', 'bgnPelengkapStatus', 'saranaStatus', 'rataStatus'], 'string'],
            [['kodeTahun'], 'integer'],
            [['nomeklatur'], 'string', 'max' => 122],
            [['kodeDesa'], 'string', 'max' => 150],
            [['luasIrigasi', 'bgnUtamaKondisi', 'bgnPengaturPengukurKondisi', 'bgnPembawaKondisi', 'bgnLindungKondisi', 'bgnPelengkapKondisi', 'saranaKondisi', 'rataKondisi'], 'string', 'max' => 100],
            [['keterangan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomeklatur' => 'Nomeklatur',
            'kodeDesa' => 'Kode Desa',
            'luasIrigasi' => 'Luas Irigasi',
            'bgnUtamaStatus' => 'Bgn Utama Status',
            'bgnUtamaKondisi' => 'Bgn Utama Kondisi',
            'bgnPengaturPengukurStatus' => 'Bgn Pengatur Pengukur Status',
            'bgnPengaturPengukurKondisi' => 'Bgn Pengatur Pengukur Kondisi',
            'bgnPembawaStatus' => 'Bgn Pembawa Status',
            'bgnPembawaKondisi' => 'Bgn Pembawa Kondisi',
            'bgnLindungStatus' => 'Bgn Lindung Status',
            'bgnLindungKondisi' => 'Bgn Lindung Kondisi',
            'bgnPelengkapStatus' => 'Bgn Pelengkap Status',
            'bgnPelengkapKondisi' => 'Bgn Pelengkap Kondisi',
            'saranaStatus' => 'Sarana Status',
            'saranaKondisi' => 'Sarana Kondisi',
            'rataStatus' => 'Rata Status',
            'rataKondisi' => 'Rata Kondisi',
            'keterangan' => 'Keterangan',
            'kodeTahun' => 'Kode Tahun',
        ];
    }

    public function getKodeTahun0()
    {
        return $this->hasOne(TahunIrigasi::class, ['tahun' => 'tahun']);
    }

    /**
     * Gets query for [[KodeDesa0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeDesa0()
    {
        return $this->hasOne(DataDesa::class, ['namaDesa' => 'KodeDesa']);
    }
}
