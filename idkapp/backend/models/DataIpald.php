<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_ipald".
 *
 * @property int $id
 * @property string|null $enumerator
 * @property string|null $fasilitas
 * @property string|null $desa
 * @property int|null $kodeKecamatan
 * @property string|null $alamat
 * @property int|null $tahunPembangunan
 * @property int|null $tahunRehabilitasi
 * @property int|null $kapasitasDesain
 * @property int|null $kapasitasPakai
 * @property string|null $sistem
 * @property int|null $kondisi
 * @property int|null $kodePengelola
 * @property int|null $cekEffluent
 * @property string|null $namaLembaga
 * @property string|null $bentukLembaga
 * @property int|null $jumlahAnggota
 * @property int|null $kodeBidang
 * @property int|null $kodeDana
 * @property int|null $kodeAset
 * @property int|null $kodeStatus
 * @property string|null $latitude
 * @property string|null $longitude
 *
 * @property IpaldDokumen[] $ipaldDokumens
 * @property AsetIpald $kodeAset0
 * @property BidangIpald $kodeBidang0
 * @property DanaIpald $kodeDana0
 * @property DataKecamatan $kodeKecamatan0
 * @property DataDesa $kodeDesa0
 * @property DataPengelola $kodePengelola0
 * @property StatusAset $kodeStatus0
 */
class DataIpald extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_ipald';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enumerator', 'fasilitas', 'sistem', 'kondisi', 'cekEffluent'], 'string'],
            [['tahunPembangunan', 'tahunRehabilitasi', 'kapasitasDesain', 'kapasitasPakai', 'jumlahAnggota'], 'integer'],
            [['kodeKecamatan', 'kodeDesa', 'alamat', 'kodePengelola', 'namaLembaga', 'bentukLembaga', 'kodeBidang', 'kodeDana', 'kodeAset', 'kodeStatus', 'latitude', 'longitude'], 'string', 'max' => 255],
            [['file'], 'file', 'skipOnEmpty' => true, 'maxSize' => 1024 * 1024 * 10], // Ukuran maksimum 10 MB per file
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'enumerator' => 'Enumerator',
            'fasilitas' => 'Fasilitas',
            'kodeKecamatan' => 'Kode Kecamatan',
            'kodeDesa' => 'Kode Desa',
            'alamat' => 'Alamat',
            'tahunPembangunan' => 'Tahun Pembangunan',
            'tahunRehabilitasi' => 'Tahun Rehabilitasi',
            'kapasitasDesain' => 'Kapasitas Desain',
            'kapasitasPakai' => 'Kapasitas Pakai',
            'sistem' => 'Sistem',
            'kondisi' => 'Kondisi',
            'kodePengelola' => 'Kode Pengelola',
            'cekEffluent' => 'Cek Effluent',
            'namaLembaga' => 'Nama Lembaga',
            'bentukLembaga' => 'Bentuk Lembaga',
            'jumlahAnggota' => 'Jumlah Anggota',
            'kodeBidang' => 'Kode Bidang',
            'kodeDana' => 'Kode Dana',
            'kodeAset' => 'Kode Aset',
            'kodeStatus' => 'Kode Status',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    /**
     * Gets query for [[IpaldDokumens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIpaldDokumens()
    {
        return $this->hasMany(IpaldDokumen::class, ['kodeDataIpald' => 'id']);
    }

    /**
     * Gets query for [[KodeAset0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeAset0()
    {
        return $this->hasOne(AsetIpald::class, ['namaAset' => 'kodeAset']);
    }

    /**
     * Gets query for [[KodeBidang0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeBidang0()
    {
        return $this->hasOne(BidangIpald::class, ['namaBidang' => 'kodeBidang']);
    }

    /**
     * Gets query for [[KodeDana0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeDana0()
    {
        return $this->hasOne(DanaIpald::class, ['sumberDana' => 'kodeDana']);
    }

    /**
     * Gets query for [[KodeKecamatan0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeKecamatan0()
    {
        return $this->hasOne(DataKecamatan::class, ['namaKecamatan' => 'kodeKecamatan']);
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

    /**
     * Gets query for [[KodePengelola0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodePengelola0()
    {
        return $this->hasOne(DataPengelola::class, ['namaPengelola' => 'kodePengelola']);
    }

    /**
     * Gets query for [[KodeStatus0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeStatus0()
    {
        return $this->hasOne(StatusAset::class, ['namaStatus' => 'kodeStatus']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Konversi kodeKecamatan menjadi namaKecamatan
            $kecamatan = DataKecamatan::findOne(['kode' => $this->kodeKecamatan]);
            if ($kecamatan) {
                $this->kodeKecamatan = $kecamatan->namaKecamatan;
            }

            // Konversi kodeDesa menjadi namaDesa
            $desa = DataDesa::findOne(['kode' => $this->kodeDesa]);
            if ($desa) {
                $this->kodeDesa = $desa->namaDesa;
            }

            return true;
        } else {
            return false;
        }
    }
}
