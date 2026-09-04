<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_individu2023".
 *
 * @property int $id
 * @property int|null $no
 * @property string|null $kode_kegiatan
 * @property string|null $kode_sub
 * @property string|null $kode_rekening
 * @property string $namaKegiatan
 * @property string|null $kecamatan
 * @property int|null $satuan
 * @property int|null $jumlah
 * @property string|null $keterangan
 */
class TblIndividu2023 extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_individu2023';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no', 'hargaSatuan', 'jumlah'], 'integer'],
            [['kode_kegiatan', 'kode_sub', 'kode_rekening', 'namaKegiatan', 'kecamatan', 'satuan','keterangan'], 'string'],
            [['namaKegiatan'], 'required'],
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
            'kode_kegiatan' => 'Kode Kegiatan',
            'kode_sub' => 'Kode Sub',
            'kode_rekening' => 'Kode Rekening',
            'namaKegiatan' => 'Nama Kegiatan',
            'kecamatan' => 'Kecamatan',
            'satuan' => 'Satuan',
            'jumlah' => 'Jumlah',
            'hargaSatuan' => 'Harga Satuan',
            'keterangan' => 'Keterangan',
        ];
    }
}
