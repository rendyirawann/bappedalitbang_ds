<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_ipald".
 *
 * @property int $id
 * @property int|null $no
 * @property string|null $enumerator
 * @property string|null $fasilitas
 * @property string|null $wilayah
 * @property int|null $thn_pembangunan
 * @property int|null $thn_rehabilitasi
 * @property int|null $kapasitas_desain
 * @property int|null $kapasitas_pakai
 * @property string|null $sistem
 * @property string|null $kondisi
 * @property string|null $pengelola
 * @property string|null $pengecekan
 * @property string|null $nama_lembaga
 * @property string|null $bentuk_lembaga
 * @property string|null $jlh_anggota
 * @property string|null $kel_bidang
 * @property string|null $operasional
 * @property string|null $asset
 * @property string|null $status
 * @property string|null $latitude
 * @property string|null $longitude
 */
class TblIpald extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_ipald';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no', 'thn_pembangunan', 'thn_rehabilitasi', 'kapasitas_desain', 'kapasitas_pakai'], 'integer'],
            [['enumerator', 'fasilitas', 'wilayah', 'sistem', 'kondisi', 'pengelola', 'pengecekan', 'nama_lembaga', 'bentuk_lembaga', 'jlh_anggota', 'kel_bidang', 'operasional', 'asset', 'status'], 'string'],
            [['latitude', 'longitude'], 'string', 'max' => 255],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'csv', 'maxSize' => 1024 * 1024 * 10], // Ukuran maksimum 10 MB per file
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
            'wilayah' => 'Wilayah',
            'thn_pembangunan' => 'Thn Pembangunan',
            'thn_rehabilitasi' => 'Thn Rehabilitasi',
            'kapasitas_desain' => 'Kapasitas Desain',
            'kapasitas_pakai' => 'Kapasitas Pakai',
            'sistem' => 'Sistem',
            'kondisi' => 'Kondisi',
            'pengelola' => 'Pengelola',
            'pengecekan' => 'Pengecekan',
            'nama_lembaga' => 'Nama Lembaga',
            'bentuk_lembaga' => 'Bentuk Lembaga',
            'jlh_anggota' => 'Jlh Anggota',
            'kel_bidang' => 'Kel Bidang',
            'operasional' => 'Operasional',
            'asset' => 'Asset',
            'status' => 'Status',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }
    public function getTblDokumenIpalds()
    {
        return $this->hasMany(TblDokumenIpald::class, ['ipald_id' => 'id']);
    }
}
