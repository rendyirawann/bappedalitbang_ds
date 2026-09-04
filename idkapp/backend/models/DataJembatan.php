<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_jembatan".
 *
 * @property int $id
 * @property string|null $namaPekerjaan
 * @property string|null $kodeDesa
 * @property string|null $kodeKecamatan
 * @property string|null $alamat
 * @property string|null $penyedia
 * @property int|null $nilaiPagu
 * @property int|null $nilaiKontrak
 * @property int|null $nilaiAddendum
 * @property string|null $nomorSpmk
 * @property string|null $nomorKontrak
 * @property string|null $nomorAddendum
 * @property string|null $nomorPho
 * @property int|null $realisasiPanjang
 * @property int|null $realisasiLebar
 * @property string|null $keterangan
 * @property int|null $tahun
 */
class DataJembatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_jembatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaPekerjaan'], 'string'],
            [['nilaiPagu', 'nilaiKontrak', 'nilaiAddendum', 'realisasiPanjang', 'realisasiLebar', 'tahun'], 'integer'],
            [['kodeDesa', 'kodeKecamatan', 'alamat', 'penyedia', 'nomorSpmk', 'nomorKontrak', 'nomorAddendum', 'nomorPho', 'keterangan'], 'string', 'max' => 255],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'namaPekerjaan' => 'Nama Pekerjaan',
            'kodeDesa' => 'Kode Desa',
            'kodeKecamatan' => 'Kode Kecamatan',
            'alamat' => 'Alamat',
            'penyedia' => 'Penyedia',
            'nilaiPagu' => 'Nilai Pagu',
            'nilaiKontrak' => 'Nilai Kontrak',
            'nilaiAddendum' => 'Nilai Addendum',
            'nomorSpmk' => 'Nomor Spmk',
            'nomorKontrak' => 'Nomor Kontrak',
            'nomorAddendum' => 'Nomor Addendum',
            'nomorPho' => 'Nomor Pho',
            'realisasiPanjang' => 'Realisasi Panjang',
            'realisasiLebar' => 'Realisasi Lebar',
            'keterangan' => 'Keterangan',
            'tahun' => 'Tahun',
        ];
    }

    public function getKodeTahun0()
    {
        return $this->hasOne(TahunJembatan::class, ['tahun' => 'tahun']);
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
