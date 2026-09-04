<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_sampah".
 *
 * @property int $id
 * @property int|null $no
 * @property string|null $enumerator
 * @property string|null $fasilitas
 * @property string|null $lokasi
 * @property string|null $kondisi
 * @property int|null $thn_pembangunan
 * @property int|null $thn_optimalisasi
 * @property string|null $kegiatan_pengurangan
 * @property string|null $jlh_sampah_masuk
 * @property string|null $jlh_sampah_terolah
 * @property string|null $jlh_sampah_residu
 * @property string|null $pengelola
 * @property string|null $nama_lembaga
 * @property string|null $bentuk_lembaga
 * @property string|null $jlh_anggota
 * @property string|null $kel_bidang
 * @property string|null $wilayah
 * @property string|null $operasional
 * @property string|null $asset
 * @property string|null $status
 * @property string|null $latitude
 * @property string|null $longitude
 */
class TblSampah extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_sampah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no', 'thn_pembangunan', 'thn_optimalisasi'], 'integer'],
            [['enumerator', 'fasilitas', 'lokasi', 'kondisi', 'kegiatan_pengurangan', 'pengelola', 'nama_lembaga', 'bentuk_lembaga', 'jlh_anggota', 'kel_bidang', 'wilayah', 'operasional', 'asset', 'status'], 'string'],
            [['jlh_sampah_masuk', 'jlh_sampah_terolah', 'jlh_sampah_residu', 'latitude', 'longitude'], 'string', 'max' => 255],
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
            'no' => 'No',
            'enumerator' => 'Enumerator',
            'fasilitas' => 'Fasilitas',
            'lokasi' => 'Lokasi',
            'kondisi' => 'Kondisi',
            'thn_pembangunan' => 'Thn Pembangunan',
            'thn_optimalisasi' => 'Thn Optimalisasi',
            'kegiatan_pengurangan' => 'Kegiatan Pengurangan',
            'jlh_sampah_masuk' => 'Jlh Sampah Masuk',
            'jlh_sampah_terolah' => 'Jlh Sampah Terolah',
            'jlh_sampah_residu' => 'Jlh Sampah Residu',
            'pengelola' => 'Pengelola',
            'nama_lembaga' => 'Nama Lembaga',
            'bentuk_lembaga' => 'Bentuk Lembaga',
            'jlh_anggota' => 'Jlh Anggota',
            'kel_bidang' => 'Kel Bidang',
            'wilayah' => 'Wilayah',
            'operasional' => 'Operasional',
            'asset' => 'Asset',
            'status' => 'Status',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    public function getTblDokumenSampahs()
    {
        return $this->hasMany(TblDokumenSampah::class, ['sampah_id' => 'id']);
    }
}
