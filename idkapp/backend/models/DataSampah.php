<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_sampah".
 *
 * @property int $id
 * @property string|null $enumerator
 * @property string|null $fasilitas
 * @property string|null $kodeDesa
 * @property string|null $kodeKecamatan
 * @property string|null $alamat
 * @property string|null $kondisi
 * @property int|null $tahunPembangunan
 * @property int|null $tahunOptimalisasi
 * @property string|null $kegiatanPengurangan
 * @property float|null $jlhSampahMasuk
 * @property float|null $jlhSampahKompos
 * @property float|null $jlhSampahResidu
 * @property string|null $kodePengelola
 * @property string|null $namaLembaga
 * @property string|null $bentukLembaga
 * @property int|null $jlhAnggota
 * @property string|null $kodeBidang
 * @property string|null $wilayah
 * @property string|null $kodeDana
 * @property string|null $kodeAset
 * @property string|null $status
 * @property string|null $latitude
 * @property string|null $longitude
 */
class DataSampah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_sampah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enumerator', 'fasilitas', 'kondisi', 'status'], 'string'],
            [['tahunPembangunan', 'tahunOptimalisasi', 'jlhAnggota'], 'integer'],
            [['jlhSampahMasuk', 'jlhSampahKompos', 'jlhSampahResidu'], 'number'],
            [['kodeDesa', 'kodeKecamatan', 'alamat', 'kegiatanPengurangan', 'kodePengelola', 'namaLembaga', 'bentukLembaga', 'kodeBidang', 'wilayah', 'kodeDana', 'kodeAset', 'latitude', 'longitude'], 'string', 'max' => 255],
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
            'kodeDesa' => 'Kode Desa',
            'kodeKecamatan' => 'Kode Kecamatan',
            'alamat' => 'Alamat',
            'kondisi' => 'Kondisi',
            'tahunPembangunan' => 'Tahun Pembangunan',
            'tahunOptimalisasi' => 'Tahun Optimalisasi',
            'kegiatanPengurangan' => 'Kegiatan Pengurangan',
            'jlhSampahMasuk' => 'Jlh Sampah Masuk',
            'jlhSampahKompos' => 'Jlh Sampah Kompos',
            'jlhSampahResidu' => 'Jlh Sampah Residu',
            'kodePengelola' => 'Kode Pengelola',
            'namaLembaga' => 'Nama Lembaga',
            'bentukLembaga' => 'Bentuk Lembaga',
            'jlhAnggota' => 'Jlh Anggota',
            'kodeBidang' => 'Kode Bidang',
            'wilayah' => 'Wilayah',
            'kodeDana' => 'Kode Dana',
            'kodeAset' => 'Kode Aset',
            'status' => 'Status',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
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
