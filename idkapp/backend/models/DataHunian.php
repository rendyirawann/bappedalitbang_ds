<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_hunian".
 *
 * @property int $id
 * @property string|null $namaPemohon
 * @property string|null $kodeDesa
 * @property string|null $kodeKecamatan
 * @property string|null $lokasiBangunan
 * @property string|null $noRegPbg
 * @property string|null $jenisBangunan
 * @property int|null $jlhUnit
 * @property int|null $retribusi
 * @property string|null $tanggal
 * @property int|null $kodeTahun
 */
class DataHunian extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_hunian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jlhUnit', 'retribusi', 'kodeTahun'], 'integer'],
            [['tanggal'], 'safe'],
            [['namaPemohon'], 'string', 'max' => 90],
            [['kodeKecamatan', 'kodeDesa'], 'string', 'max' => 90],
            [['lokasiBangunan', 'noRegPbg', 'jenisBangunan'], 'string', 'max' => 200],
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
            'namaPemohon' => 'Nama Pemohon',
            'kodeDesa' => 'Kode Desa',
            'kodeKecamatan' => 'Kode Kecamatan',
            'lokasiBangunan' => 'Lokasi Bangunan',
            'noRegPbg' => 'No Reg Pbg',
            'jenisBangunan' => 'Jenis Bangunan',
            'jlhUnit' => 'Jlh Unit',
            'retribusi' => 'Retribusi',
            'tanggal' => 'Tanggal',
            'kodeTahun' => 'Kode Tahun',
        ];
    }

    public function getKodeTahun0()
    {
        return $this->hasOne(TahunHunian::class, ['tahun' => 'tahun']);
    }

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
